<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Admin
Breadcrumbs::for('admin', function (BreadcrumbTrail $trail) {
    $trail->push('Административная панель', route('admin.index'));
});

// Admin > Users
Breadcrumbs::for('admin.users', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Пользователи', route('admin.users'));
});

// Admin > Users > Create
Breadcrumbs::for('admin.users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.users');
    $trail->push('Создать');
});

// Admin > Users > Edit
Breadcrumbs::for('admin.users.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.users');
    $trail->push('Редактировать');
});
