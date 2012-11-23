<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Copyright (C) 2012 University of the Philippines Linux Users' Group
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

class Abstain extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function insert($abstain)
	{
		return $this->db->insert('abstains', $abstain);
	}

	public function breakdown($election_id, $position_id)
	{
		$this->db->select('block, COUNT(distinct abstains.voter_id) AS count');
		$this->db->from('blocks');
		$this->db->join('blocks_elections_positions', 'blocks_elections_positions.block_id = blocks.id AND blocks_elections_positions.election_id = ' . $election_id);
		$this->db->join('voters', 'voters.block_id = blocks_elections_positions.block_id', 'left');
		$this->db->join('abstains', 'abstains.voter_id = voters.id AND abstains.election_id = ' . $election_id . ' AND abstains.position_id = ' . $position_id, 'left');
		$this->db->group_by('block');
		$this->db->order_by('block', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function count_all_by_election_id_and_position_id($election_id, $position_id)
	{
		$this->db->from('abstains');
		$this->db->where('election_id', $election_id);
		$this->db->where('position_id', $position_id);
		return $this->db->count_all_results();
	}

}

/* End of file abstain.php */
/* Location: ./application/models/abstain.php */