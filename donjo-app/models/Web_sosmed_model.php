<?php

class Web_sosmed_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_sosmed($id=0)
	{
		$sql = "SELECT * FROM media_sosial WHERE id = ?";
		$query = $this->db->query($sql, $id);
		$data = $query->row_array();
		return $data;
	}

	public function list_sosmed()
	{
		$sql = "SELECT * FROM media_sosial WHERE 1";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function update($id=0)
	{
		$data = $this->input->post();
		$link = trim($this->input->post('link'));
		
		switch ($id) {
			case '6':
				$data['link'] = preg_replace('/[^A-Za-z0-9]/', '', $link);
				break;
			case '7':
				$data['link'] = preg_replace('/[^A-Za-z0-9_]/', '', $link);
				break;
			default:
				$data['link'] = $link;
				break;
		}

		$this->db->where('id', $id);
		$outp = $this->db->update('media_sosial', $data);

		status_sukses($outp); //Tampilkan Pesan
	}

	// Penanganan khusus sesuai jenis sosmed
	public function link_sosmed($id, $link, $tipe)
	{
		
		if (empty($link)) return $link;

		switch ($id) {
			case '6':
				// Whatsapp. $link adalah nomor telpon WA seperti +6281234567890
				if($tipe == 1){
					$link = "https://api.whatsapp.com/send?phone=" . $link;
				}else{
					$link = "https://chat.whatsapp.com/" . $link;
				}
				break;
			case '7':
				// Telegram. $link adalah username Telegram seperti opensid
				if($tipe == 1){
					$link = "https://t.me/" . $link;
				}else{
					$link = "https://t.me/joinchat/" . $link;
				}
				break;
			default:
				break;
		}
		return $link;
	}
}
?>
