<?php
class M_admin extends CI_Model  {

    public function __contsruct(){
        parent::Model();
    }

	// CONFIGURATION COMBO BOX WITH DATABASE
	public function combo_box($table, $name, $value, $name_value, $pilihan, $js='', $label='', $width=''){
		echo "<select name='$name' id='$name' onchange='$js' class='form-control input-sm' style='width:$width'>";
		echo "<option value=''>".$label."</option>";
		$query = $this->db->query($table);
		foreach ($query->result() as $row){
			if ($pilihan == $row->$value){
				echo "<option value='".$row->$value."' selected>".$row->$name_value."</option>";
			} else {
				echo "<option value='".$row->$value."'>".$row->$name_value."</option>";
			}
		}
		echo "</select>";
	}
	
	//CONFIGURATION CHECKBOX ARRAY WITH DATABASE
	public function checkbox($table, $name, $value, $name_value, $pilihan=''){
		$query = $this->db->query($table);
		$array_tag = explode(',', $pilihan);
		$ceked = "";
		foreach ($query->result() as $row){
			$ceked = (array_search($row->tag_id, $array_tag) === false)? '' : 'checked';
			echo "<input type='checkbox' name='$name' id='".$row->$value."' value='".$row->$value."' ".$ceked."/><label for='".$row->$value."' style='display: inline-block'>".$row->$name_value."</label><br />";
		}
	}
	
	//CONFIGURATION CHECKBOX ARRAY WITH DATABASE
	public function checkbox_status($table, $name, $value, $name_value, $pilihan=''){
		$query = $this->db->query($table);
		$array_tag = explode(',', $pilihan);
		$ceked = "";
		foreach ($query->result() as $row){
			$ceked = (array_search($row->status_perkawinan_kode, $array_tag) === false)? '' : 'checked';
			echo "<input type='checkbox' name='$name' id='".$row->$value."' style='display: inline-block;' value='".$row->$value."' ".$ceked."/><label for='".$row->$value."' style='display: inline-block; margin-right: 10px;'>".$row->$name_value."</label>";
		}
	}
	
	//CONFIGURATION LIST ARRAY WITH DATABASE AND EXPLODE
	public function listarray($table, $name, $value, $name_value, $pilihan=''){
		$query = $this->db->query($table);
		$array_tag = explode(',', $pilihan);
		$ceked = "";
		foreach ($query->result() as $row){
			if (array_search($row->tag_id, $array_tag) === false) {
			} else {
			echo $row->$name_value.", ";
			}
		}
	}
	
	//CONFIGURATION LIST ARRAY WITH DATABASE AND EXPLODE
	public function tagsberita($table, $name, $value, $name_value, $pilihan=''){
		$query = $this->db->query($table);
		$array_tag = explode(',', $pilihan);
		$ceked = "";
		foreach ($query->result() as $row){
			if (array_search($row->tag_id, $array_tag) === false) {
			} else {
			echo "<a href='".site_url()."news/tags/".$row->tag_id."' class='tag'>".$row->$name_value."</a> ";
			}
		}
	}
	
	
	
	//CONFIGURATION TABLE ADMIN
	public function insert_admin($data){
        $this->db->insert("t_admin",$data);
    }
    
    public function update_admin($where,$data){
        $this->db->update("t_admin",$data,$where);
    }

    public function delete_admin($where){
        $this->db->delete("t_admin", $where);
    }

	public function get_admin($select, $where){
        $data = "";
		$this->db->select($select);
        $this->db->from("t_admin");
		$this->db->where($where);
		$this->db->limit(1);
		$Q = $this->db->get();
		if ($Q->num_rows() > 0){
			$data = $Q->row();
		}
		$Q->free_result();
		return $data;
	}

    public function grid_all_admin($select, $sidx,$sord,$limit,$start,$where="", $like=""){
        $data = "";
        $this->db->select($select);
        $this->db->from("admin a");
		$this->db->join('admin_level al', 'a.admin_level_kode = al.admin_level_kode', 'left');
		if ($where){$this->db->where($where);}
		if ($like){
			foreach($like as $key => $value){ 
			$this->db->like($key, $value); 
			}
		}
		$names = array('nava', 'admin');
        $this->db->where_not_in('admin_user', $names);
        $this->db->order_by($sidx,$sord);
        $this->db->limit($limit,$start);
        $Q = $this->db->get();
        if ($Q->num_rows() > 0){
            $data=$Q->result();
        }
        $Q->free_result();
        return $data;
    }

    public function count_all_admin($where="", $like=""){
        $this->db->select("*");
        $this->db->from("t_admin");		
		if ($where){$this->db->where($where);}
		if ($like){
			foreach($like as $key => $value){ 
			$this->db->like($key, $value); 
			}
		}
        $Q=$this->db->get();
        $data = $Q->num_rows();
        return $data;
    }
	

	
	// KONFIGURASI TABEL Dosen
	public function insert_dosen($data){
        $this->db->insert("t_dosen",$data);
    }
    
    public function update_dosen($where,$data){
        $this->db->update("t_dosen",$data,$where);
    }

    public function delete_dosen($where){
        $this->db->delete("t_dosen", $where);
    }

	public function get_dosen($select, $where){
        $data = "";
		$this->db->select($select);
        $this->db->from("t_dosen b");
		$this->db->join('t_kurikulum c', 'b.kurikulum_kd= c.kurikulum_kd', 'left');
		$this->db->where($where);
		$this->db->limit(1);
		$Q = $this->db->get();
		if ($Q->num_rows() > 0){
			$data = $Q->row();
		}
		$Q->free_result();
		return $data;
	}

    public function grid_all_dosen($select, $sidx, $sord, $limit, $start, $where="", $like=""){
        $data = "";
        $this->db->select($select);
        $this->db->from("t_dosen b");
		$this->db->join('t_kurikulum c', 'b.kurikulum_kd= c.kurikulum_kd', 'left');		
		if ($where){$this->db->where($where);}
		if ($like){
			foreach($like as $key => $value){ 
			$this->db->like($key, $value); 
			}
		}
        $this->db->order_by($sidx,$sord);
        $this->db->limit($limit,$start);
        $Q = $this->db->get();
        if ($Q->num_rows() > 0){
            $data=$Q->result();
        }
        $Q->free_result();
        return $data;
    }

    public function count_all_dosen($where="", $like=""){
        $this->db->select("*");
        $this->db->from("t_dosen");
		if ($where){$this->db->where($where);}
		if ($like){
			foreach($like as $key => $value){ 
			$this->db->like($key, $value); 
			}
		}
        $Q=$this->db->get();
        $data = $Q->num_rows();
        return $data;
    }
	
	// KONFIGURASI TABEL Ruangan
	public function insert_ruangan($data){
        $this->db->insert("t_ruangan",$data);
    }
    
    public function update_ruangan($where,$data){
        $this->db->update("t_ruangan",$data,$where);
    }

    public function delete_ruangan($where){
        $this->db->delete("t_ruangan", $where);
    }

	public function get_ruangan($select, $where){
        $data = "";
		$this->db->select($select);
        $this->db->from("t_ruangan");
		$this->db->where($where);
		$this->db->limit(1);
		$Q = $this->db->get();
		if ($Q->num_rows() > 0){
			$data = $Q->row();
		}
		$Q->free_result();
		return $data;
	}

    public function grid_all_ruangan($select, $sidx, $sord, $limit, $start, $where="", $like=""){
        $data = "";
        $this->db->select($select);
        $this->db->from("t_ruangan");
		if ($where){$this->db->where($where);}
		if ($like){
			foreach($like as $key => $value){ 
			$this->db->like($key, $value); 
			}
		}
        $this->db->order_by($sidx,$sord);
        $this->db->limit($limit,$start);
        $Q = $this->db->get();
        if ($Q->num_rows() > 0){
            $data=$Q->result();
        }
        $Q->free_result();
        return $data;
    }

    public function count_all_ruangan($where="", $like=""){
        $this->db->select("*");
        $this->db->from("t_ruangan");
		if ($where){$this->db->where($where);}
		if ($like){
			foreach($like as $key => $value){ 
			$this->db->like($key, $value); 
			}
		}
        $Q=$this->db->get();
        $data = $Q->num_rows();
        return $data;
    }
	
	// KONFIGURASI TABEL Kelas
	public function insert_kelas($data){
        $this->db->insert("t_kelas",$data);
    }
    
    public function update_kelas($where,$data){
        $this->db->update("t_kelas",$data,$where);
    }

    public function delete_kelas($where){
        $this->db->delete("t_kelas", $where);
    }

	public function get_kelas($select, $where){
        $data = "";
		$this->db->select($select);
        $this->db->from("t_kelas");
		$this->db->where($where);
		$this->db->limit(1);
		$Q = $this->db->get();
		if ($Q->num_rows() > 0){
			$data = $Q->row();
		}
		$Q->free_result();
		return $data;
	}

    public function grid_all_kelas($select, $sidx, $sord, $limit, $start, $where="", $like=""){
        $data = "";
        $this->db->select($select);
        $this->db->from("t_kelas");
		if ($where){$this->db->where($where);}
		if ($like){
			foreach($like as $key => $value){ 
			$this->db->like($key, $value); 
			}
		}
        $this->db->order_by($sidx,$sord);
        $this->db->limit($limit,$start);
        $Q = $this->db->get();
        if ($Q->num_rows() > 0){
            $data=$Q->result();
        }
        $Q->free_result();
        return $data;
    }

    public function count_all_kelas($where="", $like=""){
        $this->db->select("*");
        $this->db->from("t_kelas");
		if ($where){$this->db->where($where);}
		if ($like){
			foreach($like as $key => $value){ 
			$this->db->like($key, $value); 
			}
		}
        $Q=$this->db->get();
        $data = $Q->num_rows();
        return $data;
    }
	
	// KONFIGURASI TABEL Prodi
	public function insert_prodi($data){
        $this->db->insert("t_kurikulum",$data);
    }
    
    public function update_prodi($where,$data){
        $this->db->update("t_kurikulum",$data,$where);
    }

    public function delete_prodi($where){
        $this->db->delete("t_kurikulum", $where);
    }

	public function get_prodi($select, $where){
        $data = "";
		$this->db->select($select);
        $this->db->from("t_kurikulum");	
		
		if ($where){$this->db->where($where);}
		$this->db->where($where);
		$this->db->limit(1);
		$Q = $this->db->get();
		if ($Q->num_rows() > 0){
			$data = $Q->row();
		}
		$Q->free_result();
		return $data;
	}

    public function grid_all_prodi($select, $sidx, $sord, $limit, $start, $where="", $like=""){
        $data = "";
        $this->db->select($select);
        $this->db->from("t_kurikulum e");
		if ($where){$this->db->where($where);}
		if ($like){
			foreach($like as $key => $value){ 
			$this->db->like($key, $value); 
			}
		}
        $this->db->order_by($sidx,$sord);
        $this->db->limit($limit,$start);
        $Q = $this->db->get();
        if ($Q->num_rows() > 0){
            $data=$Q->result();
        }
        $Q->free_result();
        return $data;
    }

    public function count_all_prodi($where="", $like=""){
        $this->db->select("*");
        $this->db->from("t_kurikulum e");
		if ($where){$this->db->where($where);}
		if ($like){
			foreach($like as $key => $value){ 
			$this->db->like($key, $value); 
			}
		}
        $Q=$this->db->get();
        $data = $Q->num_rows();
        return $data;
    }
	
	// KONFIGURASI TABEL Matkul
	public function insert_matkul($data){
        $this->db->insert("t_matkul",$data);
    }
    
    public function update_matkul($where,$data){
        $this->db->update("t_matkul",$data,$where);
    }

    public function delete_matkul($where){
        $this->db->delete("t_matkul", $where);
    }

	public function get_matkul($select, $where){
        $data = "";
		$this->db->select($select);
        $this->db->from("t_matkul b");
		$this->db->join('t_kurikulum c', 'b.kurikulum_kd= c.kurikulum_kd', 'left');
		$this->db->where($where);
		$this->db->limit(1);
		$Q = $this->db->get();
		if ($Q->num_rows() > 0){
			$data = $Q->row();
		}
		$Q->free_result();
		return $data;
	}

    public function grid_all_matkul($select, $sidx, $sord, $limit, $start, $where="", $like=""){
        $data = "";
        $this->db->select($select);
        $this->db->from("t_matkul b");
		$this->db->join('t_kurikulum c', 'b.kurikulum_kd= c.kurikulum_kd', 'left');
		if ($where){$this->db->where($where);}
		if ($like){
			foreach($like as $key => $value){ 
			$this->db->like($key, $value); 
			}
		}
        $this->db->order_by($sidx,$sord);
        $this->db->limit($limit,$start);
        $Q = $this->db->get();
        if ($Q->num_rows() > 0){
            $data=$Q->result();
        }
        $Q->free_result();
        return $data;
    }

    public function count_all_matkul($where="", $like=""){
        $this->db->select("*");
        $this->db->from("t_matkul");
		if ($where){$this->db->where($where);}
		if ($like){
			foreach($like as $key => $value){ 
			$this->db->like($key, $value); 
			}
		}
        $Q=$this->db->get();
        $data = $Q->num_rows();
        return $data;
    }
	
	
	// KONFIGURASI TABEL Jadwal
	public function insert_jadwal($data){
        $this->db->insert("t_jadwal",$data);
    }
    
    public function update_jadwal($where,$data){
        $this->db->update("t_jadwal",$data,$where);
    }

    public function delete_jadwal($where){
        $this->db->delete("t_jadwal", $where);
    }

	public function get_jadwal($select, $where){
        $data = "";
		$this->db->select($select);
        $this->db->from("t_jadwal b");
		$this->db->join('t_dosen a', 'b.dosen_NIK= a.dosen_NIK', 'left');
		$this->db->join('t_kelas c', 'b.kelas_kd= c.kelas_kd', 'left');
		$this->db->join('t_ruangan d', 'b.ruangan_no= d.ruangan_no', 'left');
		$this->db->join('t_kurikulum e', 'b.kurikulum_kd= e.kurikulum_kd', 'left');
		$this->db->join('t_matkul f', 'b.matkul_kd= f.matkul_kd', 'left');
		$this->db->where($where);
		$this->db->limit(1);
		$Q = $this->db->get();
		if ($Q->num_rows() > 0){
			$data = $Q->row();
		}
		$Q->free_result();
		return $data;
	}

    public function grid_all_jadwal($select, $sidx, $sord, $limit, $start, $where="", $like=""){
        $data = "";
        $this->db->select($select);
       $this->db->from("t_jadwal b");
		$this->db->join('t_dosen a', 'b.dosen_NIK= a.dosen_NIK', 'left');
		$this->db->join('t_kelas c', 'b.kelas_kd= c.kelas_kd', 'left');
		$this->db->join('t_ruangan d', 'b.ruangan_no= d.ruangan_no', 'left');
		$this->db->join('t_kurikulum e', 'b.kurikulum_kd= e.kurikulum_kd', 'left');
		$this->db->join('t_matkul f', 'b.matkul_kd= f.matkul_kd', 'left');
		if ($where){$this->db->where($where);}
		if ($like){
			foreach($like as $key => $value){ 
			$this->db->like($key, $value); 
			}
		}
        $this->db->order_by($sidx,$sord);
        $this->db->limit($limit,$start);
        $Q = $this->db->get();
        if ($Q->num_rows() > 0){
            $data=$Q->result();
        }
        $Q->free_result();
        return $data;
    }


    public function count_all_jadwal2($where="", $like=""){
        $this->db->select("*");
        $this->db->from("t_jadwal b");
		$this->db->join('t_dosen a', 'b.dosen_NIK= a.dosen_NIK', 'left');
		$this->db->join('t_kelas c', 'b.kelas_kd= c.kelas_kd', 'left');
		$this->db->join('t_ruangan d', 'b.ruangan_no= d.ruangan_no', 'left');
		$this->db->join('t_kurikulum e', 'b.kurikulum_kd= e.kurikulum_kd', 'left');
		$this->db->join('t_matkul f', 'b.matkul_kd= f.matkul_kd', 'left');
		if ($where){$this->db->where($where);}
		if ($like){
			foreach($like as $key => $value){ 
			$this->db->like($key, $value); 
			}
		}
        $Q=$this->db->get();
        $data = $Q->num_rows();
        return $data;
    }
	
    public function count_all_jadwal($where="", $like=""){
        $this->db->select("*");
        $this->db->from("t_jadwal b");
		$this->db->join('t_dosen a', 'b.dosen_NIK= a.dosen_NIK', 'left');
		$this->db->join('t_kelas c', 'b.kelas_kd= c.kelas_kd', 'left');
		$this->db->join('t_ruangan d', 'b.ruangan_no= d.ruangan_no', 'left');
		$this->db->join('t_kurikulum e', 'b.kurikulum_kd= e.kurikulum_kd', 'left');
		$this->db->join('t_matkul f', 'b.matkul_kd= f.matkul_kd', 'left');
		if ($where){$this->db->where($where);}
		if ($like){
			foreach($like as $key => $value){ 
			$this->db->like($key, $value); 
			}
		}
        $Q=$this->db->get();
        $data = $Q->num_rows();
        return $data;
    }
	
	// KONFIGURASI TABEL pesan_jadwal
	public function insert_pesan_jadwal($data){
        $this->db->insert("t_booking",$data);
    }
    
    public function update_pesan_jadwal($where,$data){
        $this->db->update("t_booking",$data,$where);
    }

    public function delete_pesan_jadwal($where){
        $this->db->delete("t_booking", $where);
    }

	public function get_pesan_jadwal($select, $where){
        $data = "";
		$this->db->select($select);
        $this->db->from("t_booking b");
		$this->db->join('t_kelas c', 'b.kelas_kd= c.kelas_kd', 'left');
		$this->db->join('t_ruangan d', 'b.ruangan_no= d.ruangan_no', 'left');
		$this->db->join('t_matkul a', 'b.matkul_kd= a.matkul_kd', 'left');
		$this->db->join('t_kurikulum e', 'b.kurikulum_kd= e.kurikulum_kd', 'left');
		$this->db->where($where);
		$this->db->limit(1);
		$Q = $this->db->get();
		if ($Q->num_rows() > 0){
			$data = $Q->row();
		}
		$Q->free_result();
		return $data;
	}

    public function grid_all_pesan_jadwal($select, $sidx, $sord, $limit, $start, $where="", $like=""){
        $data = "";
        $this->db->select($select);
       $this->db->from("t_booking b");
		$this->db->join('t_kelas c', 'b.kelas_kd= c.kelas_kd', 'left');
		$this->db->join('t_ruangan d', 'b.ruangan_no= d.ruangan_no', 'left');
		$this->db->join('t_matkul a', 'b.matkul_kd= a.matkul_kd', 'left');
		$this->db->join('t_kurikulum e', 'b.kurikulum_kd= e.kurikulum_kd', 'left');
		if ($where){$this->db->where($where);}
		if ($like){
			foreach($like as $key => $value){ 
			$this->db->like($key, $value); 
			}
		}
        $this->db->order_by($sidx,$sord);
        $this->db->limit($limit,$start);
        $Q = $this->db->get();
        if ($Q->num_rows() > 0){
            $data=$Q->result();
        }
        $Q->free_result();
        return $data;
    }

    public function count_all_pesan_jadwal($where="", $like=""){
        $this->db->select("*");
        $this->db->from("t_booking");
		if ($where){$this->db->where($where);}
		if ($like){
			foreach($like as $key => $value){ 
			$this->db->like($key, $value); 
			}
		}
        $Q=$this->db->get();
        $data = $Q->num_rows();
        return $data;
    }
	
	// KONFIGURASI TABEL tambah_pengguna
	public function insert_pengguna($data){
        $this->db->insert("t_admin ",$data);
    }
    
    public function update_pengguna($where,$data){
        $this->db->update("t_admin ",$data,$where);
    }

    public function delete_pengguna($where){
        $this->db->delete("t_admin ", $where);
    }

	public function get_pengguna($select, $where){
        $data = "";
		$this->db->select($select);
        $this->db->from("t_admin b");
		$this->db->join('admin_level c', 'b.admin_level_kode= c.admin_level_kode', 'left');
		$this->db->where($where);
		$this->db->limit(1);
		$Q = $this->db->get();
		if ($Q->num_rows() > 0){
			$data = $Q->row();
		}
		$Q->free_result();
		return $data;
	}

    public function grid_all_pengguna($select, $sidx, $sord, $limit, $start, $where="", $like=""){
        $data = "";
        $this->db->select($select);
        $this->db->from("t_admin b");
		$this->db->join('admin_level c', 'b.admin_level_kode= c.admin_level_kode', 'left');
		if ($where){$this->db->where($where);}
		if ($like){
			foreach($like as $key => $value){ 
			$this->db->like($key, $value); 
			}
		}
        $this->db->order_by($sidx,$sord);
        $this->db->limit($limit,$start);
        $Q = $this->db->get();
        if ($Q->num_rows() > 0){
            $data=$Q->result();
        }
        $Q->free_result();
        return $data;
    }

    public function count_all_pengguna($where="", $like=""){
        $this->db->select("*");
        $this->db->from("t_admin");
		if ($where){$this->db->where($where);}
		if ($like){
			foreach($like as $key => $value){ 
			$this->db->like($key, $value); 
			}
		}
        $Q=$this->db->get();
        $data = $Q->num_rows();
        return $data;
    }
	
	// KONFIGURASI TABEL Kelompok
	public function insert_kelompok($data){
        $this->db->insert("admin_level ",$data);
    }
    
    public function update_kelompok($where,$data){
        $this->db->update("admin_level ",$data,$where);
    }

    public function delete_kelompok($where){
        $this->db->delete("admin_level ", $where);
    }

	public function get_kelompok($select, $where){
        $data = "";
		$this->db->select($select);
        $this->db->from("admin_level");
		$this->db->where($where);
		$this->db->limit(1);
		$Q = $this->db->get();
		if ($Q->num_rows() > 0){
			$data = $Q->row();
		}
		$Q->free_result();
		return $data;
	}

    public function grid_all_kelompok($select, $sidx, $sord, $limit, $start, $where="", $like=""){
        $data = "";
        $this->db->select($select);
        $this->db->from("admin_level");
		if ($where){$this->db->where($where);}
		if ($like){
			foreach($like as $key => $value){ 
			$this->db->like($key, $value); 
			}
		}
        $this->db->order_by($sidx,$sord);
        $this->db->limit($limit,$start);
        $Q = $this->db->get();
        if ($Q->num_rows() > 0){
            $data=$Q->result();
        }
        $Q->free_result();
        return $data;
    }

    public function count_all_kelompok($where="", $like=""){
        $this->db->select("*");
        $this->db->from("admin_level");
		if ($where){$this->db->where($where);}
		if ($like){
			foreach($like as $key => $value){ 
			$this->db->like($key, $value); 
			}
		}
        $Q=$this->db->get();
        $data = $Q->num_rows();
        return $data;
    }
}