<?php namespace App\Models;

use CodeIgniter\Model;

class QuestionModel extends Model
{
        protected $table      = 'question';
        protected $primaryKey = 'id';

        protected $returnType = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['user_id', 'survey_id', 'question', 'type'];

        protected $useTimestamps = true;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';

        protected $validationRules    = [
              'user_id'     => 'required|is_natural_no_zero',
              'survey_id'   => 'required|is_natural_no_zero',
              'question'    => 'required|alpha_numeric_punct|min_length[3]',
              'type'        => 'required|in_list[textarea,radio,select]'
        ];
        protected $validationMessages = [];
        protected $skipValidation     = false;
}
