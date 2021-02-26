<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Room_no_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get($id = null) {
        $this->db->select()->from('room_nos');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array(); 
        } else {
            return $query->result_array(); 
        }
    }

    public function remove($id) {
		$this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        $this->db->where('id', $id);
        $this->db->delete('room_nos');
		$message      = DELETE_RECORD_CONSTANT." On room_nos id ".$id;
        $action       = "Delete";
        $record_id    = $id;
        $this->log($message, $record_id, $action);
		//======================Code End==============================
        $this->db->trans_complete(); # Completing transaction
        /*Optional*/
        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
        //return $return_value;
        }
    }


 public function getClassByRoom_noAll($classid) {
     
        $this->db->select('class_room_nos.id,class_room_nos.room_no_id,room_nos.room_no');
        $this->db->from('class_room_nos');
        $this->db->join('room_nos', 'room_nos.id = class_room_nos.room_no_id');
        $this->db->where('class_room_nos.class_id', $classid);
        $this->db->order_by('class_room_nos.id');
        $query = $this->db->get();
       $room_no= $query->result_array();

        return $room_no;
    }

    public function getClassByRoom_no($classid) {
        $userdata = $this->customlib->getUserData();
        $role_id = $userdata["role_id"];
        $carray = array();
     
        if (isset($role_id) && ($userdata["role_id"] == 2) && ($userdata["class_teacher"] == "yes")) {
           
            $room_no=$this->teacher_model->get_teacherrestricted_moderoom_nos($userdata["id"],$classid);
   
            
        } else {
        $this->db->select('class_room_nos.id,class_room_nos.room_no_id,room_nos.room_no');
        $this->db->from('class_room_nos');
        $this->db->join('room_nos', 'room_nos.id = class_room_nos.room_no_id');
        $this->db->where('class_room_nos.class_id', $classid);
        $this->db->order_by('class_room_nos.id');
        $query = $this->db->get();
       $room_no= $query->result_array();
    }
  
        return $room_no;
    }

    public function getClassTeacherRoom_no($classid) {

        $userdata = $this->customlib->getUserData();
        if (($userdata["role_id"] == 2)) {
            $id = $userdata["id"];
          //  $query = $this->db->select("class_teacher.room_no_id ,class_room_nos.id,room_nos.room_no")->join('room_nos', 'room_nos.id = class_teacher.room_no_id')->join('class_room_nos', 'room_nos.id = class_room_nos.room_no_id')->where(array('class_teacher.class_id' => $classid, 'class_teacher.staff_id' => $id))->group_by("class_teacher.room_no_id")->get("class_teacher");
            $query = $this->db->select("class_teacher.room_no_id ")->join('room_nos', 'room_nos.id = class_teacher.room_no_id')->join('class_room_nos', 'room_nos.id = class_room_nos.room_no_id')->where(array('class_teacher.class_id' => $classid, 'class_teacher.staff_id' => $id))->group_by("class_teacher.room_no_id")->get("class_teacher");
              $result = $query->result_array();

              foreach ($result as $key => $value) {
                    $query2 = $this->db->select('class_room_nos.id,room_nos.room_no')
                                       ->join('room_nos','room_nos.id = class_room_nos.room_no_id')
                                       ->where('room_nos.room_no_id',$value['room_no_id'])
                                       ->get('class_room_nos');
                      $result2 = $query2->row_array();
                   $result[$key]['id'] = $result2['id'];
                    $result[$key]['room_no'] = $result2['room_no'];                         
                }  
            return $result;
        }
    }

    public function getSubjectTeacherRoom_no($classid, $id) {

          //  $query = $this->db->select("class_room_nos.id,room_nos.room_no,class_room_nos.room_no_id")->join("class_room_nos", "teacher_subjects.class_room_no_id = class_room_nos.id")->join('room_nos', 'room_nos.id = class_room_nos.room_no_id')->where(array('class_room_nos.class_id' => $classid, 'teacher_subjects.teacher_id' => $id))->group_by("class_room_nos.room_no_id")->get("teacher_subjects");

        $query = $this->db->select("class_room_nos.id,room_nos.room_no,class_room_nos.room_no_id")->join("class_room_nos", "teacher_subjects.class_room_no_id = class_room_nos.id")->join('room_nos', 'room_nos.id = class_room_nos.room_no_id')->where(array('class_room_nos.class_id' => $classid, 'teacher_subjects.teacher_id' => $id))->get("teacher_subjects");

        return $query->result_array();
    }

    public function getClassNameByRoom_no($classid, $room_noid) {
        $this->db->select('class_room_nos.id,class_room_nos.room_no_id,room_nos.room_no,classes.class');
        $this->db->from('class_room_nos');
        $this->db->join('room_nos', 'room_nos.id = class_room_nos.room_no_id');
        $this->db->join('classes', 'classes.id = class_room_nos.class_id');
        $this->db->where('class_room_nos.class_id', $classid);
        $this->db->where('class_room_nos.room_no_id', $room_noid);
        $this->db->order_by('class_room_nos.id');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function add($data) {
		$this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('room_nos', $data);
			$message      = UPDATE_RECORD_CONSTANT." On room_nos id ".$data['id'];
			$action       = "Update";
			$record_id    = $data['id'];
			$this->log($message, $record_id, $action);
			//======================Code End==============================

			$this->db->trans_complete(); # Completing transaction
			/*Optional*/

			if ($this->db->trans_status() === false) {
				# Something went wrong.
				$this->db->trans_rollback();
				return false;

			} else {
				//return $return_value;
			}
			
        } else {
            $this->db->insert('room_nos', $data);
			$id = $this->db->insert_id();		
			$message      = INSERT_RECORD_CONSTANT." On room_nos id ".$id;
			$action       = "Insert";
			$record_id    = $id;
			$this->log($message, $record_id, $action);
			//echo $this->db->last_query();die;
			//======================Code End==============================

			$this->db->trans_complete(); # Completing transaction
			/*Optional*/

			if ($this->db->trans_status() === false) {
				# Something went wrong.
				$this->db->trans_rollback();
				return false;

			} else {
				//return $return_value;
			}
        }
    }

}
