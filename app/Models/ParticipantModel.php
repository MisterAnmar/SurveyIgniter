<?php namespace App\Models;

use CodeIgniter\Model;

class ParticipantModel extends Model
{
        protected $table      = 'participant';
        protected $primaryKey = 'id';

        protected $returnType = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['survey_id', 'title', 'takers', 'finished'];

        protected $useTimestamps = true;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';

        protected $validationRules    = [
              'survey_id'   => 'required|numeric',
              'title'       => 'required|alpha_numeric_punct|min_length[3]|max_length[150]',
              'takers'      => 'required|numeric',
              'finished'    => 'required|numeric',

        ];
        protected $validationMessages = [];
        protected $skipValidation     = false;


public function updateSur()
{

}




}
