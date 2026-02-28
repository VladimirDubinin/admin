<?php

declare(strict_types=1);

namespace Modules\Users\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Users\Filters\UserFilter;
use Modules\Users\Forms\UserForm;
use Modules\Users\Models\User;
use Modules\Users\Services\UserService;

class UsersController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    )
    {}

    public function index(UserFilter $filter): View
    {
        $users = User::filter($filter)->paginate(config('app.per_page'));

        return view('admin.users.list', [
            'users' => $users,
            'pageTitle' => 'Пользователи',
            'filters' => $filter->toArray(),
        ]);
    }

    public function create(): View
    {
        return view('admin.users.user',
            [
                'pageTitle' => 'Создать пользователя',
                'form_url' => route('admin.users.get_form'),
                'store_url' => route('admin.users.store'),
                'back_url' => route('admin.users'),
            ]
        );
    }

    public function edit(int $id): View
    {
        return view('admin.users.user',
            [
                'pageTitle' => 'Редактировать пользователя',
                'form_url' => route('admin.users.get_form', ['id' => $id]),
                'store_url' => route('admin.users.store'),
                'back_url' => route('admin.users'),
                'delete_url' => route('admin.users.delete', ['id' => $id]),
            ]
        );
    }

    public function getForm(UserForm $userForm, int $id = 0): array
    {
        return $userForm->form($id)->toArray();
    }

    public function store(Request $request, UserForm $userForm): JsonResponse
    {
        $id = $request->input('id', 0);
        $fields = $userForm->form($id)->validate()->getFieldsFromRequest();
        if (!empty($id)) {
            $this->userService->update($id, $fields);
        } else {
            $this->userService->create($fields);
        }

        return response()->json(['success' => true]);
    }

    public function delete(int $id): JsonResponse
    {
        $this->userService->delete($id);
        return response()->json(['success' => true]);
    }
}
