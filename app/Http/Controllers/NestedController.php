<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Catalog;

use DB;

class NestedController extends Controller
{
    public function getNested ()
    {
        $catalog = Catalog::orderBy('sort_order','ASC')->get();
        return view('admin.nested.catalog',['catalog' => $catalog]);
    }

    public function postNested (Request $r)
    {
        if ($r->ajax()) {
            // $data = $r->get('dataString[data]');
            $data = $r->get('dataString');
            $data = json_decode($data['data']);
            $readbleArray = $this->parseJsonArray($data);
            $i=0;
            foreach($readbleArray as $row){
                $i++;
                // $db->exec("update tbl_menu set parent = '".$row['parentID']."', sort = '".$i."' where id = '".$row['id']."' ");
                DB::table('catalog')->where('id',$row['id'])->update(['parent_id' => $row['parentID'], 'sort_order' => $i]);
            }
        }
    }
    public function parseJsonArray($jsonArray, $parentID = 0) 
    {
      $return = array();
      foreach ($jsonArray as $subArray) {
        $returnSubSubArray = array();
        if (isset($subArray->children)) {
            $returnSubSubArray = $this->parseJsonArray($subArray->children, $subArray->id);
        }
        $return[] = array('id' => $subArray->id, 'parentID' => $parentID);
        $return = array_merge($return, $returnSubSubArray);
      }
      return $return;
    }    
}
