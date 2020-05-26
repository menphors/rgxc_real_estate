<?php

namespace App\Model\Attachment;

use App\Model\Attachment\AttachmentRepository;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class DbAttachmentRepository extends Repository implements AttachmentRepository
{
    public function __construct(Attachment $model)
    {
        $this->model = $model;
    }   
}