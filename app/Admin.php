<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
	protected $fillable = [
		'name', 'email', 'password', 'avatar', 'birthday', 'phone'
	];

	protected $hidden = [
		'password', 'remember_token',
	];

	protected $table = 'admins';
}
