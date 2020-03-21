<?php namespace App\Models;

use CodeIgniter\Model;

class SurveyModel extends Model
{
        protected $table      = 'survey';
        protected $primaryKey = 'id';

        protected $returnType = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['title', 'description', 'user_id'];

        protected $useTimestamps = true;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';

        protected $validationRules    = [
              'title'       => 'required|alpha_numeric_punct|min_length[3]',
              'description' => 'permit_empty|alpha_numeric_punct',
              'user_id'     => 'required|integer'
        ];
        protected $validationMessages = [];
        protected $skipValidation     = false;
}
