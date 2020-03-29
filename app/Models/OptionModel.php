<?php namespace App\Models;

use CodeIgniter\Model;

class OptionModel extends Model
{
        protected $table      = 'option';
        protected $primaryKey = 'id';

        protected $returnType = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['user_id', 'survey_id', 'question_id', 'option'];

        protected $useTimestamps = true;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';

        protected $validationRules    = [
              'user_id'     => 'required|is_natural_no_zero',
              'survey_id'   => 'required|is_natural_no_zero',
              'question_id' => 'required|is_natural_no_zero',
              'option'      => 'required|min_length[3]'
        ];
        protected $validationMessages = [];
        protected $skipValidation     = false;
}
