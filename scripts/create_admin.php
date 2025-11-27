<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$email = $argv[1] ?? null;
$password = $argv[2] ?? null;
$name = $argv[3] ?? 'Administrator';

if (! $email || ! $password) {
    fwrite(STDERR, "Usage: php scripts/create_admin.php email password [name]\n");
    exit(1);
}

/** @var \App\Models\User $user */
$user = \App\Models\User::where('email', $email)->first();

if ($user) {
    $user->is_admin = true;
    $user->password = \Illuminate\Support\Facades\Hash::make($password);
    $user->name = $name;
    $user->save();
    echo "Updated existing user id={$user->id}, email={$user->email} -> is_admin=1\n";
    exit(0);
}

$user = \App\Models\User::create([
    'name' => $name,
    'email' => $email,
    'password' => \Illuminate\Support\Facades\Hash::make($password),
]);

$user->is_admin = true;
$user->save();

echo "Created admin user id={$user->id}, email={$user->email}\n";
