<?php

namespace App\Model\Attachment;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table= "attachments";

	protected $fillable = ['object_id', 'key', 'name', 'size', 'type', 'note'];
}