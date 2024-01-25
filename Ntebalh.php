<?php
namespace App\Model\Trs\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ntebalh extends Model {

	use SoftDeletes;

	protected $connection = 'mysql';
	public $incrementing = true;
	public $timestamps = false;
	protected $hidden = [];
	protected $dates = ['deleted_at'];
	protected $table = 'ntebalh';
	protected $primaryKey = "id";
	protected $fillable = [
		'id',
		'tanggal',
		'nama_material',
		'supplier',
		'volume',
		'usl',
		'lsl',
		'created_by',
		'created_at',
		'updated_at',
		'deleted_at',
		'plant',
	];
	public function rel_created_by() {
		return $this->belongsTo('App\Model\Sys\Syuser', 'created_by');
	}

	public function rel_d1() {
		return $this->hasMany('App\Model\Trs\Local\Ntebald1', 'id_ref');
	}

}
