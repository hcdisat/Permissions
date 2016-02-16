<?php namespace ITeam\Permissions\Models;


use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ModelBase extends Model implements Transformable
{
    use TransformableTrait;

}