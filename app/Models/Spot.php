<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    use HasFactory;

    /**
     * データベース接続
     *
     * @var string
     */
    protected $connection = 'mysql_second';
}
