<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Cms extends Model
{
    use Translatable;

    protected $table = "cms";

    protected $fillable =["slug", "thumbnail", "picture", "type", "blog"];

    public $translatedAttributes = ["title", "content"];

    protected $primaryKey = "id";

    public $timestamps = true;

    public function getLinkAttribute(): string 
    {
      return route('blog', ['id' => ($this->slug ?? $this->id)]);
    }
}

class CmsTranslation extends Model
{
    protected $table = "cms_translations";

    public $timestamps = false;

    protected $fillable = ["cms_id", "locale", 'title', 'content'];
}
