<?php

namespace Database\Seeders;

use App\Models\LugarAsignacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LugarAsignacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $asignaciones = [
            ["name" => "DIRECCION GENERAL", "clave_sig" => 7],
            ["name" => "SUB DIRECCION GENERAL", "clave_sig" => 7],
            ["name" => "INSPECTORIA GENERAL", "clave_sig" => 7],
            ["name" => "DPPOMC DIRECCION DE PLANEAMIENTO, PROCEDIMIENTOS OPERATIVOS Y MEJORA CONTINUA", "clave_sig" => 7],
            ["name" => "DIPOL DIRECCION DE INTELIGENCIA POLICIAL", "clave_sig" => 7],
            ["name" => "DIRECCION DE RECURSOS HUMANOS", "clave_sig" => 7],
            ["name" => "DIRECCION DE LOGÍSTICA", "clave_sig" => 7],
            ["name" => "DAIC DIRECCION DE ASUNTOS INTERINSTITUCIONALES COMUNITARIOS", "clave_sig" => 7],
            ["name" => "UNPH UNIVERSIDAD NACIONAL DE POLICÍA DE HONDURAS", "clave_sig" => 7],
            ["name" => "DAF DIRECCION ADMINISTRATIVA FINANCIERA", "clave_sig" => 7],
            ["name" => "DPT DIRECCION POLICIAL DE TELEMATICA", "clave_sig" => 7],
            ["name" => "DCE DIRECCION DE COMUNICACION ESTRATEGICA", "clave_sig" => 7],
            ["name" => "DCP DIRECCION CEREMONIAL Y PROTOCOLO", "clave_sig" => 7],
            ["name" => "DBS DIRECCION DE BIENESTAR SOCIAL", "clave_sig" => 7],
            ["name" => "IMPOL DIRECCION DE INDUSTRIA POLICIAL", "clave_sig" => 7],
            ["name" => "DSP DIRECCION DE SANIDAD POLICIAL", "clave_sig" => 7],
            ["name" => "DDJP DIRECCION DEFENSORA Y JURIDICA POLICIAL", "clave_sig" => 7],
            ["name" => "DNPSC DIRECCION NACIONAL DE PREVENCION Y SEGURIDAD COMUNITARIA", "clave_sig" => 7],
            ["name" => "DNVT DIRECCION NACIONAL DE VIALIDAD Y TRANSPORTE", "clave_sig" => 7],
            ["name" => "DPI DIRECCION POLICIAL DE INVESTIGACIONES", "clave_sig" => 7],
            ["name" => "DNFE DIRECCION NACIONAL DE FUERZAS ESPECIALES", "clave_sig" => 7],
            ["name" => "DNSPF DIRECCION NACIONAL DE SERVICIOS POLICIALES FRONTERIZOS", "clave_sig" => 7],
            ["name" => "DNPSE DIRECCION NACIONAL DE PROTECCION Y SERVICIOS ESPECIALES", "clave_sig" => 7],
            ["name" => "DNPA DIRECCION NACIONAL POLICIAL ANTIDROGAS", "clave_sig" => 7],
            ["name" => "DIPAMCO DIRECCION POLICIAL ANTI MARAS Y PANDILLAS CONTRA EL CRIMEN ORGANIZADO", "clave_sig" => 7],
            ["name" => "DNII DIRECCIÓN NACIONAL DE INVESTIGACIÓN E INTELIGENCIA", "clave_sig" => 7],
            ["name" => "UDEP 1 ATLÁNTIDA", "clave_sig" => 3],
            ["name" => "UDEP 2 COLÓN", "clave_sig" => 3],
            ["name" => "UDEP 3 COMAYAGUA", "clave_sig" => 6],
            ["name" => "UDEP 4 COPÁN", "clave_sig" => 4],
            ["name" => "UDEP 5 CORTES", "clave_sig" => 2],
            ["name" => "UDEP 6 CHOLUTECA", "clave_sig" => 5],
            ["name" => "UDEP 7 DANLI, EL PARAISO", "clave_sig" => 1],
            ["name" => "UDEP 8 TALANGA", "clave_sig" => 1],
            ["name" => "UDEP 9 GRACIAS A DIOS", "clave_sig" => 3],
            ["name" => "UDEP 10 INTIBUCA", "clave_sig" => 6],
            ["name" => "UDEP 11 ISLAS DE LA BAHIA", "clave_sig" => 3],
            ["name" => "UDEP 12 LA PAZ", "clave_sig" => 6],
            ["name" => "UDEP 13 LEMPIRA", "clave_sig" => 4],
            ["name" => "UDEP 14 OCOTEPEQUE", "clave_sig" => 4],
            ["name" => "UDEP 15 OLANCHO", "clave_sig" => 1],
            ["name" => "UDEP 16 STA. BARBARA", "clave_sig" => 2],
            ["name" => "UDEP 17 VALLE", "clave_sig" => 5],
            ["name" => "UDEP 18 YORO", "clave_sig" => 2],
            ["name" => "UMEP 1 LOS DOLORES, TEG", "clave_sig" => 1],
            ["name" => "UMEP 2 BO. BELEN, TEG", "clave_sig" => 1],
            ["name" => "UMEP 3 LA ROSA, TEG", "clave_sig" => 1],
            ["name" => "UMEP 4 KENNEDY, TEG", "clave_sig" => 1],
            ["name" => "UMEP 5 BO. LEMPIRA, SPS", "clave_sig" => 2],
            ["name" => "UMEP 6 CHAMELECON, SPS", "clave_sig" => 2],
            ["name" => "UMEP 7 SATELITE, SPS", "clave_sig" => 2],
            ["name" => "UMEP 8 RIVERA HDZ, SPS", "clave_sig" => 2],
            ["name" => "UMEP 9 LA LIMA, CORTES", "clave_sig" => 2],
            ["name" => "UMEP 10 CHOLOMA, CORTES", "clave_sig" => 2],
            ["name" => "UMEP 11 EL PROGRESO, YORO", "clave_sig" => 2],
            ["name" => "UMEP 12 VILLANUEVA, CORTES", "clave_sig" => 2],
            ["name" => "UMEP 13 PEÑA BLANCA, CORTES", "clave_sig" => 2],
            ["name" => "UMEP 14 SABANAGRANDE, FM", "clave_sig" => 1],
            ["name" => "UMEP 15 CATACAMAS", "clave_sig" => 1],
            ["name" => "UMEP 16 SIGUATEPEQUE", "clave_sig" => 3],
            ["name" => "UMEP 17 OLANCHITO", "clave_sig" => 3],
            ["name" => "UMEP 18 TELA", "clave_sig" => 3],
            ["name" => "UMEP 19 TRUJILLO", "clave_sig" => 3],
            ["name" => "UMEP 20 LA UNION", "clave_sig" => 'N/D'],
            ["name" => "UMEP 21 YUSCARAN", "clave_sig" => 'N/D'],
            ["name" => "UMEP 22 SAN LORANZO", "clave_sig" => 'N/D'],
            ["name" => "UMEP 23 QUIMISTAN ", "clave_sig" => 'N/D'],
            ["name" => "ANAPO ACADEMIA NACIONAL DE POLICÍA", "clave_sig" => 7],
            ["name" => "ITP INSTITUTO TÉCNICO POLICIAL", "clave_sig" => 7],

        ];

        foreach ($asignaciones as $asignacion){
            LugarAsignacion::create($asignacion);
        }
    }
}
