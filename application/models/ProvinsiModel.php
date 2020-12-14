<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ProvinsiModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function listing()
    {
        $this->db->select('*');
        $this->db->from('provinsi');
        $this->db->order_by('id_provinsi', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
}
