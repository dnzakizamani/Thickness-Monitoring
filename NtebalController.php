<?php
namespace App\Http\Controllers\Trs\Local;

use App\Http\Controllers\Controller;
use App\Model\Trs\Local\Ntebalh;
use App\Model\Trs\Local\Ntebald1;
use Auth;
use DB;
use App\Sf;
use Illuminate\Http\Request;

class NtebalController extends Controller
{

	public function index(Request $request)
	{
		if (!$plant = Sf::isPlant()) {
			return Sf::selectPlant();
		}

		Sf::log("trs_local_ntebal", "NtebalController@" . __FUNCTION__, "Open Page  ", "link");

		// Retrieve data from ntebald1 table
		$ntebald1Data = DB::table('ntebald1')
			->select('id_ref', DB::raw('CONCAT_WS(", ", GROUP_CONCAT(x1), GROUP_CONCAT(x2), GROUP_CONCAT(x3), GROUP_CONCAT(x4), GROUP_CONCAT(x5), GROUP_CONCAT(x6)) AS merged_values'))
			->groupBy('id_ref')
			->get();

		// dd($ntebald1Data);

		// Pass the data to the view
		return view('trs.local.ntebal.ntebal_frm', compact('request', 'plant', 'ntebald1Data'));
	}

	public function getList(Request $request)
	{
		// if (!Sf::allowed('TRS_LOCAL_NTEBAL_R')) {
		// 	return response()->json(Sf::reason(), 401);
		// }

		$request->q = str_replace(" ", "%", $request->q);
		$data = Ntebalh::where(function ($q) use ($request) {
			$q->orWhere('id', 'like', "%" . @$request->q . "%");
			$q->orWhere('tanggal', 'like', "%" . @$request->q . "%");
			$q->orWhere('nama_material', 'like', "%" . @$request->q . "%");
			$q->orWhere('supplier', 'like', "%" . @$request->q . "%");
			$q->orWhere('volume', 'like', "%" . @$request->q . "%");
			$q->orWhere('usl', 'like', "%" . @$request->q . "%");
			$q->orWhere('lsl', 'like', "%" . @$request->q . "%");
		})
			->whereDate('tanggal', '>=', @$request->date1)
			->whereDate('tanggal', '<=', @$request->date2)
			->with(['rel_d1'])
			//->where('plant',$request->plant)
			->orderBy(isset($request->order_by) ? substr($request->order_by, 1) : 'tanggal', substr(@$request->order_by, 0, 1) == '-' ? 'asc' : 'desc');
		if ($request->trash == 1) {
			$data = $data->onlyTrashed();
		}
		$data = $data->paginate(isset($request->limit) ? $request->limit : 10);
		$data->getCollection()->transform(function ($value) {
			//isikan transformasi disini
			$value->token = Sf::encrypt($value->id); // Get all related Ntebald1 data
			$idRef = $value->id; // Assuming id is used as id_ref, modify accordingly if needed
			$stats = Ntebald1::where('id_ref', $idRef)
				->selectRaw('
					ROUND(MAX(GREATEST(x1, x2, x3, x4, x5, x6)), 2) as xmax,
					ROUND(MIN(LEAST(x1, x2, x3, x4, x5, x6)), 2) as xmin,
					ROUND((AVG(x1) + AVG(x2) + AVG(x3) + AVG(x4) + AVG(x5) + AVG(x6)) / 6, 2) as xavg,
					ROUND(MAX(GREATEST(x1, x2, x3, x4, x5, x6)) - MIN(LEAST(x1, x2, x3, x4, x5, x6)), 2) as xrange'
				)
				->groupBy('id_ref')
				->get();

			// Check if any rows are found
			if (!$stats->isEmpty()) {
				// Retrieve the first row (assuming all rows have the same values)
				$firstRow = $stats->first();

				// Add the calculated values to the result
				$value->xmax = $firstRow->xmax;
				$value->xmin = $firstRow->xmin;
				$value->xavg = $firstRow->xavg;
				$value->xrange = $firstRow->xrange;
			} else {
				// Set default values if no rows are found
				$value->xmax = null;
				$value->xmin = null;
				$value->xavg = null;
				$value->xrange = null;
			}

			return $value;
		});
		info($data);
		return response()->json(compact(['data']));
	}


	public function getLookup(Request $request)
	{
		$request->q = str_replace(" ", "%", $request->q);
		$data = Ntebalh::where(function ($q) use ($request) {
			$q->orWhere('id', 'like', "%" . @$request->q . "%");
			$q->orWhere('nama_material', 'like', "%" . @$request->q . "%");
			$q->orWhere('tanggal', 'like', "%" . @$request->q . "%");
			$q->orWhere('supplier', 'like', "%" . @$request->q . "%");
			$q->orWhere('volume', 'like', "%" . @$request->q . "%");
			$q->orWhere('usl', 'like', "%" . @$request->q . "%");
			$q->orWhere('lsl', 'like', "%" . @$request->q . "%");
		})
			->with(['rel_d1'])
			//->where('plant',$request->plant)
			->orderBy(isset($request->order_by) ? substr($request->order_by, 1) : 'id', substr(@$request->order_by, 0, 1) == '-' ? 'desc' : 'asc');
		$data = $data->paginate(isset($request->limit) ? $request->limit : 10);
		return view('sys.system.dialog.sflookup', compact(['data', 'request']));
	}

	public function store(Request $request)
	{
		$req = json_decode(request()->getContent());
		$h = $req->h;
		$f = $req->f;
		if (@$h->tanggal) {
			$h->tanggal = date('Y-m-d', strtotime($h->tanggal));
		}


		try {
			$arr = array_merge((array) $h, ['plant' => $f->plant, 'updated_at' => date('Y-m-d H:i:s')]);
			if ($f->crud == 'c') {
				// if (!Sf::allowed('TRS_LOCAL_NTEBAL_C')) {
				// 	return response()->json(Sf::reason(), 401);
				// }
				$data = new Ntebalh();
				$arr = array_merge($arr, ['created_by' => Auth::user()->userid, 'created_at' => date('Y-m-d H:i:s')]);
				$data->create($arr);
				$id = DB::getPdo()->lastInsertId();
				Sf::log("trs_local_ntebal", $id, "Create Mitutoyo (ntebal) id : " . $id, "create");
				$this->saveNtebald1($id, $h->rel_d1);
				return response()->json('created');
			} else {
				// if (!Sf::allowed('TRS_LOCAL_NTEBAL_U')) {
				// 	return response()->json(Sf::reason(), 401);
				// }
				$id = Sf::decrypt($h->token);
				$data = Ntebalh::find($id);
				if ($data === null) {
					return response()->json("error token", 400);
				}
				$data->update($arr);
				$ntebalhId = $data->id;

				// Hapus semua data ntebald1 yang terkait
				Ntebald1::where('id_ref', $ntebalhId)->delete();

				// Simpan kembali data ke tabel ntebald1
				$this->saveNtebald1($ntebalhId, $h->rel_d1);
				return response()->json('updated');
			}

		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}

	public function edit($token)
	{
		$id = Sf::decrypt($token);
		$h = Ntebalh::where('id', $id)->with(['rel_d1'])->withTrashed()->first();
		if ($h === null) {
			return response()->json("error token", 400);
		}
		$h->token = $token;
		// $h->tanggal = date('d-m-Y', strtotime($h->tanggal));
		return response()->json(compact(['h']));
	}

	public function destroy($token, Request $request)
	{
		try {
			$id = Sf::decrypt($token);
			$data = Ntebalh::where('id', $id)->withTrashed()->first();
			if ($data === null) {
				return response()->json("error token", 400);
			}
			if ($request->restore == 1) {
				if (!Sf::allowed('TRS_LOCAL_NTEBAL_S')) {
					return response()->json(Sf::reason(), 401);
				}
				$data->restore();
				Sf::log("trs_local_ntebal", $id, "Restore Mitutoyo (ntebal) id : " . $id, "restore");
				return response()->json('restored');
			} else {
				if (!Sf::allowed('TRS_LOCAL_NTEBAL_D')) {
					return response()->json(Sf::reason(), 401);
				}
				$data->delete();
				Sf::log("trs_local_ntebal", $id, "Delete Mitutoyo (ntebal) id : " . $id, "delete");
				return response()->json('deleted');
			}
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}

	private function saveNtebald1($ntebalhId, $relD1)
	{
		if ($relD1 && is_array($relD1)) {
			foreach ($relD1 as $item) {
				Ntebald1::create([
					'id_ref' => $ntebalhId, // Sesuaikan dengan id_ref yang sesuai dengan id di tabel ntebalh
					'x1' => $item->x1 == '' ? null : $item->x1,
					'x2' => $item->x2 == '' ? null : $item->x2,
					'x3' => $item->x3 == '' ? null : $item->x3,
					'x4' => $item->x4 == '' ? null : $item->x4,
					'x5' => $item->x5 == '' ? null : $item->x5,
					'x6' => $item->x6 == '' ? null : $item->x6,
					'created_by' => Auth::user()->userid,

				]);
			}
		}
	}
}