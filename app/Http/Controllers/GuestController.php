<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuestRequest;
use App\Http\Requests\UpdateGuestRequest;
use Illuminate\Http\Request;
use App\Models\Guest;
use App\Http\Resources\GuestResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Services\Invitations\InvitationFactory;

class GuestController extends Controller
{

    /**
     * Получить статистику по гостям для текущего пользователя.
     */
    public function stats(): JsonResponse
    {
        // Получаем ID текущего залогиненного пользователя
        $userId = Auth::id();

        // Делаем один быстрый запрос к базе: группируем гостей по полю 'status' и считаем их количество
        $stats = \App\Models\Guest::where('user_id', $userId)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status'); // превратит в удобный массив ['confirmed' => 10, 'pending' => 5]

        return response()->json([
            'total' => $stats->sum(), // Общее количество
            'confirmed' => $stats->get('confirmed', 0),
            'pending' => $stats->get('pending', 0),
            'declined' => $stats->get('declined', 0),
        ]);
    }
    public function index(Request $request)
    {
        // 1. Начинаем строить SQL-запрос. 
        // Если админ — берём всех, если обычный юзер — только его гостей.
        $query = Guest::query();

        if ($request->user()->role !== 'admin') {
            $query->where('user_id', $request->user()->id);
        }

        // 2. Фильтр по стороне (groom/bride). 
        // Если в URL есть ?side=..., то добавляем условие в базу
        $query->when($request->has('side'), function ($q) use ($request) {
            $q->where('side', $request->input('side'));
        });

        // 3. Фильтр по статусу присутствия (confirmed/pending/declined)
        $query->when($request->has('status'), function ($q) use ($request) {
            $q->where('status', $request->input('status'));
        });

        // 4. Вместо get() или all() включаем пагинацию! 
        // Выводим по 5-10 записей для теста (давай поставим 10)
        $guests = $query->paginate(10);

        // 5. Возвращаем коллекцию через наш Ресурс
        return GuestResource::collection($guests);
    }

    public function store(StoreGuestRequest $request)
    {
        Gate::authorize('create', Guest::class);

        // Если здесь стоит validated(), значит StoreGuestRequest настроен идеально!
        $validated = $request->validated();

        $validated['user_id'] = $request->user()->id;

        $guest = Guest::create($validated);

        return new GuestResource($guest);
    }
    public function show(Guest $guest)
    {
        Gate::authorize('view', $guest);

        return new GuestResource($guest);
    }
    public function update(UpdateGuestRequest $request, Guest $guest)
    {
        Gate::authorize('update', $guest);

        $guest->update($request->validated());

        return new GuestResource($guest);
    }
    public function destroy(Guest $guest)
    {
        Gate::authorize('delete', $guest);

        $guest->delete();

        return response()->json(null, 204);
    }

    /**
     * Генерировать пригласительные для всех гостей.
     */
    public function generateAllInvitations()
    {
        // 1. Вытаскиваем всех гостей из базы данных SQLite
        $guests = Guest::all();

        // 2. Инициализируем нашу архитектурную фабрику
        $factory = new InvitationFactory();

        $result = [];

        foreach ($guests as $guest) {
            // 3. Фабрика на лету создает нужный класс (Web или Pdf) на основе $guest->category
            $invitationWorker = $factory->make($guest);

            // 4. Запускаем генерацию (сервер выполняет контрактный метод)
            $result[] = [
                'guest_name' => $guest->name,
                'category'   => $guest->category,
                // Сюда запишется либо URL-строка, либо путь к файлу на сервере
                'invitation' => $invitationWorker->generate($guest),
            ];
        }

        // 5. Отдаем чистый JSON-ответ фронтенду
        return response()->json([
            'success' => true,
            'data'    => $result
        ]);
    }
}
