<?php
namespace App\Model\Trs\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ntebald1 extends Model {

	use SoftDeletes;

	protected $connection = 'mysql';
	public $incrementing = true;
	public $timestamps = false;
	protected $hidden = [];
	protected $dates = ['deleted_at'];
	protected $table = 'ntebald1';
	protected $primaryKey = "id";
	protected $fillable = [
		'id',
		'id_ref',
		'x1',
		'x2',
		'x3',
		'x4',
		'x5',
		'x6',
		'created_by',
		'created_at',
		'updated_at',
		'deleted_at',
		'plant',
		
	];

	// public function rel_created_by() {
	// 	return $this->belongsTo('App\Model\Sys\Syuser', 'created_by');
	// }


}
