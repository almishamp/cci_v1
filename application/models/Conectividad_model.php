<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conectividad_model extends CI_Model{

	public function __construct(){

		$this->load->database('db1');
	}

	function getListConectividad($statusServicio){

		$this->db->select('idConectividad, claveCT, nombreCT, statusServicio, rm.nombreMunicipio as municipio, localidad, 				 m.nombre as modalidad, ne.nombre as nivelEducativo, t.nombre as turno');    
		$this->db->from('conectividad as c');
		$this->db->join('CA_RegionMunicipio as rm', 'rm.idMunicipio = c.idMunicipio');
		$this->db->join('CA_Modalidad as m', 'm.idModalidad = c.idModalidad');
		$this->db->join('CA_NivelEducativo as ne', 'ne.idNivelEducativo = c.idNivelEducativo');
		$this->db->join('CA_Turno as t', 't.idTurno = c.idTurno');
		$this->db->where('c.statusServicio', $statusServicio);
		$query = $this->db->get();
		return $query->result_array();
	}

	function getCentro($idConectividad){
		$this->db->select('idConectividad, claveCT, nombreCT, statusServicio, latitud, longitud, nombreRespSitio, 					   nombreRespInventario, localidad, colonia, rm.nombreMunicipio as municipio, m.nombre as         modalidad, ne.nombre as nivelEducativo, t.nombre as turno');    
		$this->db->from('conectividad as c');
		$this->db->join('CA_RegionMunicipio as rm', 'rm.idMunicipio = c.idMunicipio');
		$this->db->join('CA_Modalidad as m', 'm.idModalidad = c.idModalidad');
		$this->db->join('CA_NivelEducativo as ne', 'ne.idNivelEducativo = c.idNivelEducativo');
		$this->db->join('CA_Turno as t', 't.idTurno = c.idTurno');
		$this->db->where('idConectividad', $idConectividad);
		$query = $this->db->get();
		return $query->row_array();

	}

	function getCentroByClave($claveCT){
		$this->db->select('idConectividad, claveCT, nombreCT, statusServicio, latitud, longitud, nombreRespSitio, 					   nombreRespInventario, localidad, colonia, rm.nombreMunicipio as municipio, m.nombre as         modalidad, ne.nombre as nivelEducativo, t.nombre as turno');    
		$this->db->from('conectividad as c');
		$this->db->join('CA_RegionMunicipio as rm', 'rm.idMunicipio = c.idMunicipio');
		$this->db->join('CA_Modalidad as m', 'm.idModalidad = c.idModalidad');
		$this->db->join('CA_NivelEducativo as ne', 'ne.idNivelEducativo = c.idNivelEducativo');
		$this->db->join('CA_Turno as t', 't.idTurno = c.idTurno');
		$this->db->where('claveCT', $claveCT);
		$query = $this->db->get();
		return $query->row_array();

	}

	function getProgramas($idConectividad){

		$this->db->select('cp.nombre as programa,p.status as status, p.idPrograma as idPrograma, p.gid as gid, p.vsatid as vsatid, tp.nombre as tipoprograma, cpv.nombre as proveedor, p.idCatProveedor as idCatProveedor, p.idCatTipoPrograma as idCatTipoPrograma');
		$this->db->from('conectividad as c');
		$this->db->join('programa as p', 'p.idConectividad = c.idConectividad');
		$this->db->join('CA_Programas as cp', 'cp.idCatPrograma = p.idCatPrograma');
		$this->db->join('CA_Tipoprograma tp', 'tp.idCatTipoPrograma = p.idCatTipoPrograma');
		$this->db->join('CA_Proveedores as cpv', 'cpv.idCatProveedor = p.idCatProveedor');
		$this->db->where('c.idConectividad', $idConectividad);
		$query = $this->db->get();

		return $query->result_array();
	}

	function getArticulos($idConectividad){
		 $query = $this->db->get_where('articulo', array('idConectividad' => $idConectividad));

		return $query->result_array();
	}


	function getCentroByClaveCTSAGA($claveCT){

		$query = $this->db->get_where('conectividad', array('claveCT' => $claveCT));

		return $query->row_array();
	}

	function getCentroByClaveCTCTBA($claveCT){
		$query = $this->db->query("select* from  [SILCEQ.USEBEQ.EDU.MX].[SOPORTE].[DBO].[A_CTBA] where CLAVECCT = '$claveCT'");

		return $query->row_array();
	}

	function updateConectividad($data, $idConectividad){
		$this->db->where('idConectividad', $idConectividad);
		$this->db->update('conectividad', $data);

		return $this->db->affected_rows();
	}

}

?>