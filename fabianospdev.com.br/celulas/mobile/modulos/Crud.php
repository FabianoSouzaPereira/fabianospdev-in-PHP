<?php
namespace mobile\modulos;

/**
 *
 * @author fabiano
 *        
 */
interface Crud
{
    /** tem acesso a tudo TIPO 1 */
    public Const ADMINISTRADOR="administrador"; 
    /* tem acesso a nivel estadual TIPO 2 */
    public Const COORDENADOR = "coordenador"; 
    /* tem acesso toda sua igreja TIPO 3 */
    public Const PASTOR = 'pastor'; 
    /* tem acesso a sua célula TIPO 4*/
    public Const LIDER = 'lider';
    /* tem acesso somente leitura TIPO 5*/
    public Const COLABORADOR = 'colaborador';
    /** TIPO 6 */
    public Const COMUM = 'comum';
    
    public Const SEM_ACESSO = 'sem acesso';
   
    /** ADMIN Ler todas os registros */
    function read();
    
    /** ADMIN Ler um registro por sua id */
    function readById($id);
   
    /** ADMIN Ler todo o registro em uma id */
    function readWholeByid($id);
   
    /** ADMIN Ler registros apagados */
    function readDeleteds();
    
    /** ADMIN Inserir registro */
    function insert();
   
    /** ADMIN Atualizar Registro */
    function update();
    
    /** ADMIN ADMIN Apagar Registro por sua id */
    function deleteByid($id);
    
    /** ADMIN Apagar registro pendente definitivamente */
    function deletePendente($id);
   
    /** ADMIN Apagar todos os registros definitivamente */
    function deleteAll();
   
    /** ADMIN Pega ultimo registro inserido no banco de dados */
    function lastId();
    
    /** PASTOR Ler todas os registros */
    function pastorRead();
    
    /** PASTOR Ler um registro por sua id */
    function pastorReadById($id);
    
    /** PASTOR Ler todo o registro em uma id */
    function pastorReadWholeByid($id);
    
    /** PASTOR Ler registros apagados */
    function pastorReadDeleteds();
    
    /** PASTOR Inserir registro */
    function pastorInsert();
    
    /** PASTOR Atualizar Registro */
    function pastorUpdate();
    
    /** PASTOR ADMIN Apagar Registro por sua id */
    function pastorDeleteByid($id);
    
    /** PASTOR Apagar registro pendente definitivamente */
    function pastorDeletePendente($id);
    
    /** PASTOR Apagar todos os registros definitivamente */
    function pastorDeleteAll();
}

