<?php
class SampleCollectorModel extends MasterModel {

        public function __construct()
        {
                $this->load->database();
        }

        public function set_feedback($data)
        {
                return $this->db->insert('sample_collector',$data);
                //  $this->session->set_flashdata('msg', 'Data added successfully..');
        }

        public function getSampleData()
        {
                $result=$this->db->get('sample_collector');
                return $result->result();
        }

        public function get_by_id($id) 
        {
                $this->db->where('id',$id);
                $query = $this->db->get('sample_collector');
                return $query->result();
        }
        public function delete($id)
        {
                $this->db->where('id', $id);
                return $this->db->delete('sample_collector');
        }
        public function update_feed($id,$data)
        {
                $this->db->where('id', $id);
                return $this->db->update('sample_collector',$data);
        }
    }
?>
