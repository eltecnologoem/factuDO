<?php
require('pdo.php');

$test = 1;

# Funcion para comprobar credenciales de incio de sesion Administradores.
function AdminLogin($username, $password, $pdo){
    $query = "SELECT * FROM users WHERE `username` = :username";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':username', $username);

    $stmt->execute() or die(implode(' >> ', $stmt->errorInfo()));

    if($stmt->rowCount() > 0 ){

        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if(password_verify($password, $user->password)){
            openSession();

            $query = "SELECT code FROM profiles_permissions, permissions WHERE id = permissions AND profile = :profile";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':profile', $user->profile);

            $stmt->execute() or die(implode(' >> ', $stmt->errorInfo()));

            $user->perm = array();
            while($row = $stmt->fetch(PDO::FETCH_OBJ)){
                $user->perm[] = $row->code;
            }

            $_SESSION['user'] = $user;

            return true;

        }else {
            return false;
        }

    }else {
        return false;
    }
}

# Funcion para comprobar credenciales de incio de sesion Miembros.
function MembersLogin($username, $password, $pdo){
    $query = "SELECT * FROM _miembros WHERE `username` = :username";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':username', $username);

    $stmt->execute() or die(implode(' >> ', $stmt->errorInfo()));

    if($stmt->rowCount() > 0 ){

        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if(password_verify($password, $user->password)){
            openSession();

            $query = "SELECT code FROM members_profiles_permissions, permissions WHERE id = permissions AND profile = :profile";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':profile', $user->profile);

            $stmt->execute() or die(implode(' >> ', $stmt->errorInfo()));

            $user->perm = array();
            while($row = $stmt->fetch(PDO::FETCH_OBJ)){
                $user->perm[] = $row->code;
            }

            $_SESSION['member'] = $user;
            return true;

        }else {
            return false;
        }

    }else {
        return false;
    }
}

# Funcion para agregar usuario del sistema
function UserAdd($nombre, $username, $password, $pdo){
   
    if(trim($username) == '' or trim($password) == '' or trim($nombre) == ''){
          
        exit('No puede dejar campos en blanco.');
    }
  
    $query = "SELECT id FROM users WHERE `username`=:username"; 
    
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':username', $username);
    $stmt->execute() or die(implode(' >> ', $smmt->errorInfo()));

    if($stmt->rowCount() > 0){

        exit('Lo sentimos, pero este usuario ya existe en el sistema.');

    }
    
    $password = password_hash($password, PASSWORD_BCRYPT);

    $query = "INSERT INTO users (`username`, `password`, `nombre`) VALUES (:username, :password, :nombre)";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);

    $stmt->execute() or die(implode(" >> ", $stmt->errorInfo()));

}

# Funcion para seleccionar un usuario del sistema
function UserSelect($id, $pdo){

    $query = "SELECT * FROM users WHERE `id` = :id"; 
    $userlist = $pdo->prepare($query);

    $userlist->bindParam(':id', $id);

    $userlist->execute() or die(implode(">>", $userlist->errorInfo));
    #$user = $userlist->fetch(PDO::FETCH_OBJ);

    #return 
        #$userlist->fetch(PDO::FETCH_OBJ);

    if($userlist->rowCount() > 0){
        return $userlist->fetch(PDO::FETCH_OBJ);

    }else{
        header('Location: userList.php');

    }

}

# Funcion para listar usuarios
function UserList($pdo){

    $query = "SELECT * FROM users"; 
    
    $list = $pdo->prepare($query);

    $list->execute();

    return $list->fetchAll(PDO::FETCH_OBJ);

}

# Funcion para actualizar usuario del sistema
function UserMod($id, $nombre, $username, $password, $pdo){
    $query = "SELECT * FROM users WHERE id = $id";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam($username);
    $stmt->execute() or die(implode(' >> ', $stmt->errorInfo()));

    $user = $stmt->fetch(PDO::FETCH_OBJ);

    if($nombre === $user->nombre){
       
        $nombre = $user->nombre;
    
    }else {
        $nombre = $nombre;
    }
    
    if($username === $user->username){
           
        $username = $user->username;
    
    }else {
        $username = $username ;
    }
    
    if($password === $user->password){
           
        $password = $password;
    
    }else {
        $password = password_hash($password, PASSWORD_BCRYPT);
    }
    
    $update = "UPDATE `users` SET `username` = '$username', `password` = '$password', `nombre` = '$nombre' WHERE `id` = $id"; 
    
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':nombre', $nombre);

    $stmt = $pdo->prepare($update);
    
    $stmt->execute() or die(implode(" >> ", $stmt->errorInfo()));

}

# Funcion para eliminar usuario del sistema
function UserDel($id, $pdo){
    $query = "DELETE * FROM users WHERE id = $id";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam($username);
    $stmt->execute() or die(implode(' >> ', $stmt->errorInfo()));
}

# Funcion para estableces cookie de sesion.
function openSession(){
    if(!isset($_SESSION)){
        session_start();
    }
}

# Funcion para eliminar cookie de sesion
function closeSession(){
    if(isset($_SESSION)){
        session_destroy();
    }
}

# Funcion para agregar miembro
function MemberAdd($nombre, $cedula, $nacimiento, $sexo, $boda, $correo, $conyuge, $telefono, $celular, $telefono2, $telefono3, $direccion, $ciudad, $zona, $sector, $pdo){
   
    if(trim($nombre) == '' or trim($cedula) == '' or trim($nacimiento) == '' or trim($sexo) == '' or trim($boda) == '' or trim($correo) == ''or trim($conyuge) == ''
    or trim($telefono) == '' or trim($celular) == '' or trim($direccion) == '' or trim($ciudad) == '' or trim($zona) == '' or trim($sector) == ''){
           exit('No puede dejar campos en blanco.');
    }
     #"INSERT INTO `miembros` (`id`, `perfil`, `NOMBRE`, `CEDULA`, `TELEFONO`, `EMAIL`, `SEXO`, `ZONA`, `CIUDAD`, `sectores`, `DIRECCION`, `INGRESO`, `CONTACTO`, `CELULAR`, `TELEFONO2`, `TELEFONO3`, `ALERGICO`, `BODA`, `ESTADO_CIVIL`, `CONYUGE`, `PROFESION`, `COSECHA`, `SEGUROMEDICO`, `CLUB_APOYO`, `NACIMIENTO`, `EDUCACION`, `TIPO`, `SANGRE`, `ALFABETIZADO`, `SOCIEDAD`, `COMO_VINO`, `FECHA_CONVERSION`, `CONVERTIDO`, `BAUTIZADO`, `BAUTIZADO_ES`, `MINISTERIO`, `ESTATUS`, `COMENTARIO`, `NOTAS`, `FECHA_REGISTRO`, `HORA_REGISTRO`) VALUES ('\')";
    $addmember = "INSERT INTO _miembros (`nombre`, `cedula`, `nacimiento`, `sexo`, `boda`, `correo`, `conyuge`, `telefono`, `celular`, `telefono2`, `telefono3`, `direccion`, `ciudad`, `zona`, `sector`)
                VALUES (:nombre, :cedula, :nacimiento, :sexo, :boda, :correo, :conyuge, :telefono, :celular, :telefono2, :telefono3, :direccion, :ciudad, :zona, :sector)";

    $stmt = $pdo->prepare($addmember);

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':cedula', $cedula);
    $stmt->bindParam(':nacimiento', $nacimiento);
    $stmt->bindParam(':sexo', $sexo);
    $stmt->bindParam(':boda', $boda);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':conyuge', $conyuge);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':celular', $celular);
    $stmt->bindParam(':telefono2', $telefono2);
    $stmt->bindParam(':telefono3', $telefono3);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':ciudad', $ciudad);
    $stmt->bindParam(':zona', $zona);
    $stmt->bindParam(':sector', $sector);

    $stmt->execute() or die(implode(' >> ', $smmt->errorInfo()));

    if($stmt->rowCount() > 0){

        exit('Datos cargados con exito.');

    }

}

# Funcion para eliminar un mienbro
function MemberDel($id, $pdo){

    $query = "DELETE FROM `_miembros` WHERE `id` = :id"; 
    $userdel = $pdo->prepare($query);

    $userdel->bindParam(':id', $id);

    $userdel->execute() or die(implode(">>", $userdel->errorInfo));

    if($userdel->rowCount() > 0){
        return 'Miembro eliminado';

    }else{
        header('Location: membersList.php');
        
    }

}

# Funcion para modificar miembro.
function MemberMod($id, $nombre, $cedula, $nacimiento, $sexo, $boda, $correo, $conyuge, $cosecha,
                    $telefono, $celular, $telefono2, $telefono3, $direccion, $ciudad, $zona, $sector, $pdo){
   
    if(trim($nombre) == '' or trim($cedula) == '' or trim($nacimiento) == '' or trim($sexo) == '' or trim($correo) == ''or trim($telefono) == ''
     or trim($celular) == '' or trim($direccion) == '' or trim($ciudad) == '' or trim($zona) == '' or trim($sector) == ''){
           exit('No puede dejar campos en blanco.');
    }
    
    $query = "SELECT * FROM _miembros WHERE id = $id";
 
    $stmt = $pdo->prepare($query);
      $stmt->bindParam($id);
      $stmt->execute() or die(implode(' >> ', $stmt->errorInfo()));
      
      $member = $stmt->fetch(PDO::FETCH_OBJ);
      
       if($nombre === $member->nombre){
         
          $nombre = $member->nombre;
      
      }else {
          $nombre = $nombre;
      }
      
      if($cedula === $member->cedula){
             
          $cedula = $member->cedula;
      
      }else {
          $cedula = $cedula ;
      }
      
      if($nacimiento === $member->nacimiento){
             
          $nacimiento = $member->nacimiento;
      
      }else {
          $nacimiento = $nacimiento ;
      }
      
      if($sexo === $member->sexo){
             
          $sexo = $member->sexo;
      
      }else {
          $sexo = $sexo ;
      }
      
      if($boda === $member->boda){
             
          $boda = $member->boda;
      
      }else {
          $boda = $boda ;
      }
      
      if($correo === $member->correo){
             
          $correo = $member->correo;
      
      }else {
          $correo = $correo ;
      }
      
      if($conyuge === $member->conyuge){
             
          $conyuge = $member->conyuge;
      
      }else {
          $conyuge = $conyuge ;
      }
      
      if($cosecha === $member->cosecha){
             
          $cosecha = $member->cosecha;
      
      }else {
          $cosecha = $cosecha ;
      }
      
      if($telefono === $member->telefono){
             
          $telefono = $member->telefono;
      
      }else {
          $telefono = $telefono ;
      }
      
      if($celular === $member->celular){
             
          $celular = $member->celular;
      
      }else {
          $celular = $celular ;
      }
      
      if($telefono2 === $member->telefono2){
             
          $telefono2 = $member->telefono2;
      
      }else {
          $telefono2 = $telefono2 ;
      }
      
      if($telefono3 === $member->telefono3){
             
          $telefono3 = $member->telefono3;
      
      }else {
          $telefono3 = $telefono3 ;
      }
      
      if($direccion === $member->direccion){
             
          $direccion = $member->direccion;
      
      }else {
          $direccion = $direccion ;
      }
      
      if($ciudad === $member->ciudad){
             
          $ciudad = $member->ciudad;
      
      }else {
          $ciudad = $ciudad ;
      }
      
      if($zona === $member->zona){
             
          $zona = $member->zona;
      
      }else {
          $zona = $zona ;
      }
      
      if($sector === $member->sector){
             
          $sector = $member->sector;
      
      }else {
          $sector = $sector ;
      }


    $addmember = "INSERT INTO miembros (`nombre`, `cedula`, `nacimiento`, `sexo`, `boda`, `correo`, `conyuge`, `cosecha`, `telefono`, `celular`, `telefono2`, `telefono3`, `direccion`, `ciudad`, `zona`, `sector`)
                VALUES (:nombre, :cedula, :nacimiento, :sexo, :boda, :correo, :conyuge, :cosecha, :telefono, :celular, :telefono2, :telefono3, :direccion, :ciudad, :zona, :sector) WHERE `id`=:id";

    $stmt = $pdo->prepare($addmember);

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':cedula', $cedula);
    $stmt->bindParam(':nacimiento', $nacimiento);
    $stmt->bindParam(':sexo', $sexo);
    $stmt->bindParam(':boda', $boda);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':conyuge', $conyuge);
    $stmt->bindParam(':cosecha', $cosecha);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':celular', $celular);
    $stmt->bindParam(':telefono2', $telefono2);
    $stmt->bindParam(':telefono3', $telefono3);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':ciudad', $ciudad);
    $stmt->bindParam(':zona', $zona);
    $stmt->bindParam(':sector', $sector);

    $stmt->execute() or die(implode(' >> ', $smmt->errorInfo()));

    /*if($stmt->rowCount() > 0){

        exit('Datos cargados con exito.');

    }*/
   
}

# Funcion para buscar miembro
function MemberList($pdo){

    $query_MList = "SELECT * FROM _miembros"; 
    
    $MList = $pdo->prepare($query_MList);
    
    $MList->execute() or die(implode(">>", $MList->errorInfo));
    
    if($MList->rowCount() > 0){
        return $MList->fetchALL(PDO::FETCH_ASSOC);

    }else{
        return false;
   
    }

}

# Funcion para seleccionar miembro
function MemberSelect($id, $pdo){

    $query = "SELECT * FROM `miembros` WHERE `id` = :id"; 
    $data = $pdo->prepare($query);

    $data->bindParam(':id', $id);

    $data->execute() or die(implode(">>", $data->errorInfo));
    

    if($data->rowCount() > 0){
        return $data->fetch(PDO::FETCH_OBJ);

    }else{      
       echo'<script type="text/javascript">
    alert("Lo sentimos, pero el usuario que intenta modificar no se pudo comprobar.");
    window.location.href="memberList.php";
    </script>';
    }

}

# Funcion para seleccionar notas pastorales de cada miembro
function MemberNoteSelect($id, $pdo){

    $query = "SELECT * FROM `nostas_pastoral` WHERE `id_miembro` = :id"; 
    $Mnotas = $pdo->prepare($query);

    $Mnotas->bindParam(':id', $id);

    $Mnotas->execute() or die(implode(">>", $Mnotas->errorInfo));
    

    if($Mnotas->rowCount() > 0){
        return $Mnotas->fetchAll(PDO::FETCH_OBJ);

    }else{
        
       echo'Sin datos para mostrar.';
    }
   
}

# Funcion para insertar notas pastorales de cada miembro
function MemberNoteInsert($id_miembro, $nota, $pdo){

    $query = "INSERT INTO `nostas_pastoral` (`id_miembro`,`nota`) VALUES (:id_miembro, :nota)"; 
    $Mnotas = $pdo->prepare($query);

    $Mnotas->bindParam(':id_miembro', $id_miembro);
    $Mnotas->bindParam(':nota', $nota);

    $Mnotas->execute() or die(implode(">>", $Mnotas->errorInfo));
   
}

# Funcion para listado de ubicaciones geograficas
function ListaGeografica($pdo){

    # Funcion para listado de zonas geograficas
    $query = "SELECT * FROM zonas "; 
    $zonas = $pdo->prepare($query);
    $zonas->execute() or die(implode(">>", $zonas->errorInfo));
    
    $Zonas = $zonas->fetchAll(PDO::FETCH_OBJ);

    # Funcion para listado de ciudades geograficas
    $query = "SELECT * FROM ciudades"; 
    $ciudades = $pdo->prepare($query);
    $ciudades->execute() or die(implode(">>", $ciudades->errorInfo));
    
    $Ciudades = $ciudades->fetchAll(PDO::FETCH_OBJ);

    # Funcion para listado de sectores
    $query = "SELECT * FROM sectores"; 
    $sectores = $pdo->prepare($query);
    $sectores->execute() or die(implode(">>", $sectores->errorInfo));
    
    $Sectores = $sectores->fetchAll(PDO::FETCH_OBJ);



    return array(
        Zonas => $Zonas,
        Ciudades => $Ciudades,
        Sectores => $Sectores,
            
    ); 


}

# Funcion para seleccionar Zona-Ciudad->Sector
function MemberSelectGlobal($id, $pdo){
    $DataM = MemberSelect($id, $pdo);

    $query = "SELECT NOMBRE FROM zonas WHERE `ZONA` = :IdZona"; 
    $ZonaID = $pdo->prepare($query);
    $ZonaID->bindParam(':IdZona', $DataM->ZONA);
    $ZonaID->execute() or die(implode(">>", $ZonaID->errorInfo));
    $Zona = $ZonaID->fetch(PDO::FETCH_OBJ);
    
    $query = "SELECT NOMBRE FROM ciudades WHERE `id` = :IdCiudad";
    $IdCiudad = $pdo->prepare($query);
    $IdCiudad->bindParam(':IdCiudad', $DataM->CIUDAD);
    $IdCiudad->execute() or die(implode(">>", $IdCiudad->errorInfo));
    $Ciudad = $IdCiudad->fetch(PDO::FETCH_OBJ);

    $query = "SELECT NOMBRE FROM sectores WHERE `SECTOR` = :IdSector";
    $IdSector = $pdo->prepare($query);
    $IdSector->bindParam(':IdSector', $DataM->SECTOR);
    $IdSector->execute() or die(implode(">>", $IdSector->errorInfo));
    $Sector = $IdSector->fetch(PDO::FETCH_OBJ);

    $query = "SELECT sexo FROM genero WHERE `id` = :IdSexo"; 
    $IdSexo = $pdo->prepare($query);
    $IdSexo->bindParam(':IdSexo', $DataM->SEXO);
    $IdSexo->execute() or die(implode(">>", $IdSexo->errorInfo));
    $Sexo = $IdSexo->fetch(PDO::FETCH_OBJ);

    $query = "SELECT Estatus FROM estado_civil WHERE `id` = :IdCivil"; 
    $IdCivil = $pdo->prepare($query);
    $IdCivil->bindParam(':IdCivil', $DataM->ESTADO_CIVIL);
    $IdCivil->execute() or die(implode(">>", $IdCivil->errorInfo));
    $Civil = $IdCivil->fetch(PDO::FETCH_OBJ);
    
    $query = "SELECT profesion FROM profesiones WHERE `id` = :IdProfesion"; 
    $IdProfesion = $pdo->prepare($query);
    $IdProfesion->bindParam(':IdProfesion', $DataM->PROFESION);
    $IdProfesion->execute() or die(implode(">>", $IdProfesion->errorInfo));
    $Profesion = $IdProfesion->fetch(PDO::FETCH_OBJ);

    $query = "SELECT NOMBRE FROM estatus WHERE `estatus` = :IdStateMember"; 
    $IdStateMember = $pdo->prepare($query);
    $IdStateMember->bindParam(':IdStateMember', $DataM->ESTATUS);
    $IdStateMember->execute() or die(implode(">>", $IdStateMember->errorInfo));
    $StateMember = $IdStateMember->fetch(PDO::FETCH_OBJ);

    $Geo = array(
                    Zona => $Zona->NOMBRE,
                    Ciudad => $Ciudad->NOMBRE,
                    Sector => $Sector->NOMBRE,
    );

            return array(
                Miembro => $DataM,
                Sexo => $Sexo,
                Civil => $Civil,
                Estado => $StateMember,
                Profesion => $Profesion,
                Geo => $Geo,
                    
            );    
   
}

# Funcion para seleccionar Todo para Miembros
function DataSelectGlobal( $pdo){

    #$DataM = MemberList($pdo);
   
    $queryzonas = "SELECT NOMBRE FROM zonas"; 
    $ZonaID = $pdo->prepare($queryzonas);
    $ZonaID->execute() or die(implode(">>", $ZonaID->errorInfo));
    $Zona = $ZonaID->fetchAll(PDO::FETCH_OBJ);
    
    $queryciudades = "SELECT NOMBRE FROM ciudades";
    $IdCiudad = $pdo->prepare($queryciudades);
    $IdCiudad->execute() or die(implode(">>", $IdCiudad->errorInfo));
    $Ciudad = $IdCiudad->fetchAll(PDO::FETCH_OBJ);

    $querysectores = "SELECT NOMBRE FROM sectores";
    $IdSector = $pdo->prepare($querysectores);
    $IdSector->execute() or die(implode(">>", $IdSector->errorInfo));
    $Sector = $IdSector->fetchAll(PDO::FETCH_OBJ);

    $querygenero = "SELECT sexo FROM genero"; 
    $IdSexo = $pdo->prepare($querygenero);
    $IdSexo->execute() or die(implode(">>", $IdSexo->errorInfo));
    $Sexo = $IdSexo->fetchAll(PDO::FETCH_OBJ);

    $querytipo_sangre = "SELECT tipo FROM tipo_sangre"; 
    $IdSangre = $pdo->prepare($querytipo_sangre);
    $IdSangre->execute() or die(implode(">>", $IdSangre->errorInfo));
    $Sangre = $IdSangre->fetchAll(PDO::FETCH_OBJ);
    
    $queryestado_civil = "SELECT Estatus FROM estado_civil"; 
    $IdCivil = $pdo->prepare($queryestado_civil);
    $IdCivil->execute() or die(implode(">>", $IdCivil->errorInfo));
    $Civil = $IdCivil->fetchAll(PDO::FETCH_OBJ);

    $queryestadomebresia = "SELECT NOMBRE FROM estatus"; 
    $IdMembresia = $pdo->prepare($queryestadomebresia);
    $IdMembresia->execute() or die(implode(">>", $IdMembresia->errorInfo));
    $MembresiaS = $IdMembresia->fetchAll(PDO::FETCH_OBJ);

    $queryprofesion = "SELECT * FROM profesiones "; 
    $profesion = $pdo->prepare($queryprofesion);
    $profesion->execute() or die(implode(">>", $profesion->errorInfo));
    $profesiones = $profesion->fetchAll(PDO::FETCH_OBJ);

            return array(
                #Miembro => $DataM,
                Genero => $Sexo,
                Sangre => $Sangre,
                Profesiones => $profesiones,
                Civil => $Civil,
                EstadoMiembro => $MembresiaS,
                Zonas => $Zona,
                Ciudades => $Ciudad,
                Sectores => $Sector,
                    
            );    
   
}

# Funcion para convertir Nombre a ID para MemberMod
function MemberDataConvert($NombreZona, $NombreCiudad, $NombreSector, $NombreSexo, $EstatusCivil, $NombreProfesion, $pdo){
    #$DataM = MemberSelect($id, $pdo);

    $query = "SELECT ZONA FROM zonas WHERE `NOMBRE` = :NombreZona"; 
    $ZonaN = $pdo->prepare($query);
    $ZonaN->bindParam(':NombreZona', $NombreZona);
    $ZonaN->execute() or die(implode(">>", $ZonaN->errorInfo));
    $ZonaD = $ZonaN->fetch(PDO::FETCH_OBJ);
    
    $query = "SELECT id FROM ciudades WHERE `NOMBRE` = :NombreCiudad";
    $City = $pdo->prepare($query);
    $City->bindParam(':NombreCiudad', $NombreCiudad);
    $City->execute() or die(implode(">>", $City->errorInfo));
    $CiudadD = $City->fetch(PDO::FETCH_OBJ);

    $query = "SELECT SECTOR FROM sectores WHERE `NOMBRE` = :NombreSector";
    $SectorN = $pdo->prepare($query);
    $SectorN->bindParam(':NombreSector', $NombreSector);
    $SectorN->execute() or die(implode(">>", $SectorN->errorInfo));
    $SectorD = $SectorN->fetch(PDO::FETCH_OBJ);

    $query = "SELECT id FROM genero WHERE `sexo` = :NombreSexo"; 
    $SexoN = $pdo->prepare($query);
    $SexoN->bindParam(':NombreSexo', $NombreSexo);
    $SexoN->execute() or die(implode(">>", $SexoN->errorInfo));
    $SexoD = $SexoN->fetch(PDO::FETCH_OBJ);

    $query = "SELECT id FROM estado_civil WHERE `Estatus` = :EstatusCivil"; 
    $CivilS = $pdo->prepare($query);
    $CivilS->bindParam(':EstatusCivil', $EstatusCivil);
    $CivilS->execute() or die(implode(">>", $CivilS->errorInfo));
    $CivilD = $CivilS->fetch(PDO::FETCH_OBJ);

    $query = "SELECT id FROM profesiones WHERE `profesion` = :NombreProfesion"; 
    $ProfesionN = $pdo->prepare($query);
    $ProfesionN->bindParam(':NombreProfesion', $NombreProfesion);
    $ProfesionN->execute() or die(implode(">>", $ProfesionN->errorInfo));
    $ProfesionD = $ProfesionN->fetch(PDO::FETCH_OBJ);

            return   array(
                #Miembro => $DataM,
                Zona => $ZonaD->ZONA,
                Ciudad => $CiudadD->id,
                Sector => $SectorD->SECTOR,
                Sexo => $SexoD->id,
                Civil => $CivilD->id,
                Profesion => $ProfesionD->id,
                    
            );    
   
}

# Funcion para leer los perfiles
function getProfiles($pdo){
    $query = "SELECT * FROM profiles"; 
    $stmt = $pdo->prepare($query);

    $stmt->execute() or die(implode('>>', $stmt->errorInfo()));
    
    return $stmt->fetchALL(PDO::FETCH_OBJ);

   
}

# Funcion para leer los permisos de usuario
function getProPerm($pdo){

    $query = "SELECT CONCAT(profile, ',', permissions) AS perm FROM profiles_permissions";
    $stmt = $pdo->prepare($query);

    $stmt->execute() or die(implode('>>', $stmt->errorInfo()));

    if($stmt->rowCount() > 0){
        
        $perm = array();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $perm[] = $row->perm;
        }

    }else {
        return false;
    }

    return $perm;
}

# Funcion para leer los permisos de usuario
function getPermissions($pdo){

    $profiles = getProfiles($pdo);
    $proPerm = getProPerm($pdo);

    $all = array();

    foreach($profiles as $profile){
        $query = "SELECT * FROM `permissions`"; 
        $stmt = $pdo->prepare($query);

        $stmt->execute() or die(implode('>>', $stmt->errorInfo()));

        if($stmt->rowCount() > 0){
            $permissions = array();
            while($row = $stmt->fetch(PDO::FETCH_OBJ)){
                $row->concat = $profile->id . ',' . $row->id;
                if($proPerm){
                $row->set = in_array($row->concat, $proPerm);
                }else{
                    $row->set = false;
                }
                $permissions[] = $row;

            }
    
        }else {
            return false;
        }

        $all[] = array('id'=>$profile->id, 'name'=>$profile->profile, 'permissions'=>$permissions);
    }

    return $all;
}

# Funcion para leer los permisos de usuario
function setPermissions($profile, $permissions, $pdo){

    $query = "DELETE FROM `profiles_permissions` WHERE profile = :profile";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':profile', $profile);

    $stmt->execute() or die(implode('>>', $stmt->errorInfo()));

    if(isset($permissions)){
    $query = "INSERT INTO `profiles_permissions` (`profile`, `permissions`) VALUES (:profile, :permissions)";
    
    $stmt = $pdo->prepare($query);
    
    foreach($permissions as $permission){
        $data = array('profile'=>$profile, 'permissions'=>$permission);
        $stmt->execute($data) or die(implode('>>', $stmt->errorInfo()));
    }
                }
    return true;
}


# Funcion para leer los perfiles Miembros
function MemberGetProfiles($pdo){
    $query = "SELECT * FROM members_profiles"; 
    $stmt = $pdo->prepare($query);

    $stmt->execute() or die(implode('>>', $stmt->errorInfo()));
    
    return $stmt->fetchALL(PDO::FETCH_OBJ);

   
}

# Funcion para leer los permisos de Miembros
function MemberGetProPerm($pdo){

    $query = "SELECT CONCAT(profile, ',', permissions) AS perm FROM members_profiles_permissions";
    $stmt = $pdo->prepare($query);

    $stmt->execute() or die(implode('>>', $stmt->errorInfo()));

    if($stmt->rowCount() > 0){
        
        $perm = array();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $perm[] = $row->perm;
        }

    }else {
        return false;
    }

    return $perm;
}

# Funcion para leer los permisos de Miembros
function MemberGetPermissions($pdo){

    $profiles = MemberGetProfiles($pdo);
    $proPerm = MemberGetProPerm($pdo);

    $all = array();

    foreach($profiles as $profile){
        $query = "SELECT * FROM `members_permissions`"; 
        $stmt = $pdo->prepare($query);

        $stmt->execute() or die(implode('>>', $stmt->errorInfo()));

        if($stmt->rowCount() > 0){
            $permissions = array();
            while($row = $stmt->fetch(PDO::FETCH_OBJ)){
                $row->concat = $profile->id . ',' . $row->id;
                if($proPerm){
                $row->set = in_array($row->concat, $proPerm);
                }else{
                    $row->set = false;
                }
                $permissions[] = $row;

            }
    
        }else {
            return false;
        }

        $all[] = array('id'=>$profile->id, 'name'=>$profile->profile, 'permissions'=>$permissions);
    }

    return $all;
}

# Funcion para leer los permisos de Miembros
function MemberSetPermissions($profile, $permissions, $pdo){

    $query = "DELETE FROM `members_profiles_permissions` WHERE profile = :profile";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':profile', $profile);

    $stmt->execute() or die(implode('>>', $stmt->errorInfo()));

    if(isset($permissions)){
    $query = "INSERT INTO `members_profiles_permissions` (`profile`, `permissions`) VALUES (:profile, :permissions)";
    
    $stmt = $pdo->prepare($query);
    
    foreach($permissions as $permission){
        $data = array('profile'=>$profile, 'permissions'=>$permission);
        $stmt->execute($data) or die(implode('>>', $stmt->errorInfo()));
    }
                }
    return true;
}

# Funcion Profesion para datos Miembros
function ListaProfesiones($pdo){

    $queryProfesion = "SELECT * FROM profesiones "; 
    $profesiones = $pdo->prepare($queryProfesion);
    $profesiones->execute() or die(implode(">>", $profesiones->errorInfo));
    
        return $profesiones->fetchAll(PDO::FETCH_OBJ); 


}


# Funciones manejo articulos

# Funcion para crear articulo.
function post_add($id_autor, $titulo, $url_imagen, $post_content, $tags, $category, $autor, $fecha_post, $rID, $uri, $pdo){
    $query_post = "INSERT INTO post (`id_autor`, `titulo`, `url_imagen`, `post_content`, `tags`, `category`, `autor`, `fecha_post`, `rID`, `uri`) VALUES (:id_autor, :titulo, :url_imagen, :post_content, :tags, :category, :autor, :fecha_post, :rID, :uri)";

    $post_add = $pdo->prepare($query_post);
    $post_add->bindParam(':id_autor', $id_autor);
    $post_add->bindParam(':titulo', $titulo);
    $post_add->bindParam(':url_imagen', $url_imagen);
    $post_add->bindParam(':post_content', $post_content);
    $post_add->bindParam(':tags', $tags);
    $post_add->bindParam(':category', $category);
    $post_add->bindParam(':autor', $autor);
    $post_add->bindParam(':fecha_post', $fecha_post);
    $post_add->bindParam(':rID', $rID);
    $post_add->bindParam(':uri', $uri);

    $post_add->execute() or die(implode('>>', $post_add->errorInfo()));

    if(isset($_SESSION['user'])){
        UserActivity($_SESSION['user']->id, $_SESSION['user']->nombre.' - Solicitó ejecución F= post_add() usando URI= /'.$uri.'.', $pdo);
    }elseif(isset($_SESSION['member'])){
        UserActivity($_SESSION['member']->id, $_SESSION['member']->nombre.' - Creaste un nuevo articulo URL= blog/'.$uri.'.htm/', $pdo);
    }else{
        UserActivity(0, 'Guest User - Solicitó ejecución F= post_select_uri() usando URI='.$post_uri.'. Post_ID='.$post_data->id_articulo.'.', $pdo);
    }

}

# Funcion para modificar articulo.
function post_mod($id_articulo , $titulo, $url_imagen, $post_content, $tags, $category, $uri, $fecha_update, $id_autor_update, $autor_update, $pdo){
    $query_post = "UPDATE post SET `titulo` = :titulo, `url_imagen` = :url_imagen, `post_content` = :post_content, `tags` = :tags, `category` = :category, `uri` = :uri, `fecha_update`= :fecha_update, `id_autor_update`= :id_autor_update, `autor_update`= :autor_update WHERE id_articulo = :id_articulo";

    $post_update = $pdo->prepare($query_post);
    $post_update->bindParam(':id_articulo', $id_articulo);
    $post_update->bindParam(':titulo', $titulo);
    $post_update->bindParam(':url_imagen', $url_imagen);
    $post_update->bindParam(':post_content', $post_content);
    $post_update->bindParam(':tags', $tags);
    $post_update->bindParam(':category', $category);
    $post_update->bindParam(':uri', $uri);
    $post_update->bindParam(':fecha_update', $fecha_update);
    $post_update->bindParam(':id_autor_update', $id_autor_update);
    $post_update->bindParam(':autor_update', $autor_update);

    $post_update->execute() or die(implode('>>', $post_update->errorInfo()));

}

# Funcion para indexar articulo.
function post_index($pdo){
    $query_post_read = "SELECT * FROM post ORDER BY fecha_post DESC";

    $post_read = $pdo->prepare($query_post_read);

    $post_read->execute() or die(implode('>>', $post_read->errorInfo()));

    if($post_read->rowCount() > 0){
        return $post_read->fetchAll(PDO::FETCH_OBJ); 
    }else{
        return array();
    }

}

# Funcion para indexar articulo Top5.
function post_index_top5($pdo){
    $query_post_read = "SELECT id_articulo, titulo, url_imagen, fecha_post, uri FROM post ORDER BY fecha_post DESC LIMIT 5";

    $post_read = $pdo->prepare($query_post_read);

    $post_read->execute() or die(implode('>>', $post_read->errorInfo()));

    if($post_read->rowCount() > 0){
        return $post_read->fetchAll(PDO::FETCH_OBJ); 
    }else{
        return array();
    }

}

# Funcion para indexar articulo Trending.
function post_index_trending($pdo){
    $query_post_read = "SELECT * FROM post ORDER BY fecha_post DESC";

    $post_read = $pdo->prepare($query_post_read);

    $post_read->execute() or die(implode('>>', $post_read->errorInfo()));

    if($post_read->rowCount() > 0){
        return $post_read->fetchAll(PDO::FETCH_OBJ); 
    }else{
        return array();
    }

}

# Funcion para seleccionar articulo con ID.
function post_select($post_id, $pdo){
    $query_post_read = "SELECT * FROM post WHERE `id_articulo` = :id";

    $post_read = $pdo->prepare($query_post_read);
    $post_read->bindParam(':id', $post_id);

    $post_read->execute() or die(implode('>>', $post_read->errorInfo()));

    if($post_read->rowCount() > 0){
        return $post_read->fetch(PDO::FETCH_OBJ);    
    }else{
        header('Location: ./');
    }
}

# Funcion para seleccionar articulo con URI.
function post_select_uri($post_uri, $pdo){
    $query_post_read = "SELECT * FROM post WHERE `uri` = :post_uri";

    $post_read = $pdo->prepare($query_post_read);
    $post_read->bindParam(':post_uri', $post_uri);

    $post_read->execute() or die(implode('>>', $post_read->errorInfo()));

    if($post_read->rowCount() > 0){
        $post_data = $post_read->fetch(PDO::FETCH_OBJ);
        if(isset($_SESSION['user'])){
            UserActivity($_SESSION['user']->id, $_SESSION['user']->nombre.' - Solicitó ejecución F= post_select_uri() usando URI='.$post_uri.'. Post_ID='.$post_data->id_articulo.'.', $pdo);
        }elseif(isset($_SESSION['member'])){
            UserActivity($_SESSION['member']->id, $_SESSION['member']->nombre.' - Visitaste /'.$post_uri.'.htm', $pdo);
        }else{
            UserActivity(0, 'Guest User - Solicitó ejecución F= post_select_uri() usando URI='.$post_uri.'. Post_ID='.$post_data->id_articulo.'.', $pdo);
        }
        return $post_data;    
    }else{
        header('Location: ./');
    }
}

#Seleccionar post ID con rID
function post_select_rID($rID, $pdo){
    UserActivity($_SESSION['user']->id, $_SESSION['user']->nombre.' - Solicitó la ejecución de F= post_select_rID() usando rID='.$rID, $pdo);

    $query_post_read = "SELECT id_articulo, uri FROM post WHERE `rID` = :rID";

    $post_read = $pdo->prepare($query_post_read);
    $post_read->bindParam(':rID', $rID);

    $post_read->execute() or die(implode('>>', $post_read->errorInfo()));

    if($post_read->rowCount() > 0){
        $_rID = $post_read->fetch(PDO::FETCH_OBJ);
        UserActivity($_SESSION['user']->id, $_SESSION['user']->nombre.' - Obtuvo los datos del post ID='.$_rID->id_articulo.' y elimino rID='.$rID.'. F= post_select_rID().', $pdo);

        $query_null_rid = "UPDATE `post` SET `rID` = NULL WHERE `id_articulo` = $_rID->id_articulo";

        $null_rid = $pdo->prepare($query_null_rid);   
        $null_rid->execute() or die(implode('>>', $null_rid->errorInfo()));
        
        return  $_rID->uri;

    }else{
        header('Location: ./');
    }
    UserActivity($_SESSION['user']->id, $_SESSION['user']->nombre.' - No pudo obtener los datos del post asociado a rID='.$rID.'. F= post_select_rID().', $pdo); 

}

#Set NULL post rID
function post_rID_NULL($rID, $pdo){
    $rIDt = $rID;
    $query_post_read = "SELECT id_articulo FROM post WHERE `rID` = :rID";

    $post_read = $pdo->prepare($query_post_read);
    $post_read->bindParam(':rID', $rID);

    $post_read->execute() or die(implode('>>', $post_read->errorInfo()));

    if($post_read->rowCount() > 0){
        UserActivity($_SESSION['user']->id, $_SESSION['user']->nombre.' - Consultó tabla post->id_articulo usando rID='.$rID, $pdo);

        $rID = $post_read->fetch(PDO::FETCH_OBJ);

        $query_null_rid = "UPDATE `post` SET `rID` = NULL WHERE `id_articulo` = $rID->id_articulo";

        $null_rid = $pdo->prepare($query_null_rid);   
        $null_rid->execute() or die(implode('>>', $null_rid->errorInfo()));

        UserActivity($_SESSION['user']->id, $_SESSION['user']->nombre.' - Eliminó rID='.$rIDt.' para post '.$rID->id_articulo.' en la tabla post.', $pdo);

        $post_id = $rID->id_articulo;

        return $post_id;
        
    }

    UserActivity($_SESSION['user']->id, $_SESSION['user']->nombre.' - No se pudo completar ejecución de post_rID_NULL() para post asociado a rID='.$rIDt.' en la tabla post.', $pdo);
    exit;       

}

# Convertidor Titulo en URL Amigable
function titulo_a_url($toClean){
	$chars = array(
        '?' => 'S', '?' => 's', 'Ð' => 'Dj','?' => 'Z', '?' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
        'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',
        'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
        'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss','à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
        'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
        'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
        'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'ƒ' => 'f', ',' => '',  '.' => '',  ':' => '',
        ';' => '',  '_' => '',  '<' => '',  '>' => '',  '\\'=> '',  'ª' => '',  'º' => '',  '!' => '',  '|' => '',  '"' => '',
        '@' => '',  '·' => '',  '#' => '',  '$' => '',  '~' => '',  '%' => '',  '€' => '',  '&' => '',  '¬' => '',  '/' => '',
        '(' => '',  ')' => '',  '=' => '',  '?' => '',  '\''=> '',  '¿' => '',  '¡' => '',  '`' => '',  '+' => '',  '´' => '',
        'ç' => '',  '^' => '',  '*' => '',  '¨' => '',  'Ç' => '',  '[' => '',  ']' => '',  '{' => '',  '}' => '',  '? '=> '-',
    );
	$toClean = str_replace('&', '-and-', $toClean);
	$toClean = str_replace('.', '', $toClean);
	$toClean = strtolower(strtr($toClean, $chars));
	$toClean = str_replace(' ', '-', $toClean);
	$toClean = str_replace('--', '-', $toClean);
	$toClean = str_replace('--', '-', $toClean);
	$toClean = preg_replace('/[^\w\d_ -]/si', '', $toClean);
    return trim($toClean);
    
    UserActivity($_SESSION['user']->id, $_SESSION['user']->nombre.'Ejecutó correctamente la funcion interna titulo_a_url()', $pdo);
}

## Funciones para registro de actividad
### Obtener dirección visitante/cliente/usuario
function getRealIP(){

    if (isset($_SERVER["HTTP_CLIENT_IP"]))
    {
        return $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
    {
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
    {
        return $_SERVER["HTTP_X_FORWARDED"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
    {
        return $_SERVER["HTTP_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED"]))
    {
        return $_SERVER["HTTP_FORWARDED"];
    }
    else
    {
        return $_SERVER["REMOTE_ADDR"];
    }

}

### Registro de actividad
function UserActivity($user_id, $activity, $pdo){
    $ip = getRealIP();
    $date_access = time();
    $user_activity = "INSERT INTO `sys_user_activity` (`user_id`, `user_activity`, `date_access`, `ip_address`) VALUES ('$user_id', '$activity', '$date_access', '$ip')";
    
    $activity = $pdo->prepare($user_activity);            
    $activity->execute() or die(implode(' >> ', $activity->errorInfo()));
}

#Lectura de actividad general
function UserActivityReadAll($pdo){
    if(in_array('R_allLogs', $_SESSION['user']->perm)){

        $_activity = "SELECT * FROM `sys_user_activity`  ORDER BY `accion_id` DESC ";
        
        $activity = $pdo->prepare($_activity);            
        $activity->execute() or die(implode(' >> ', $activity->errorInfo()));

        if($activity->rowCount() > 0 ){
            $log = $activity->fetchAll(PDO::FETCH_OBJ);
        
            return $log;
        }else{
            return "Sin registros para mostrar";
        }
    }else{
        echo'<script type="text/javascript">
        alert("Lo sentimos, no tienes permiso para esta operación.");
        window.location.href="./?Home";
        </script>';
    }

}

#Lectura de actividad Miembro individual
function UserActivity_mMyLog($mem_uID, $pdo){
    if(in_array('R_Logs', $_SESSION['member']->perm)){

        $_activity = "SELECT * FROM `sys_user_activity` WHERE `user_id` = '$mem_uID' ORDER BY `accion_id` DESC ";
        
        $activity = $pdo->prepare($_activity);            
        $activity->execute() or die(implode(' >> ', $activity->errorInfo()));

        if($activity->rowCount() > 0 ){
            $log = $activity->fetchAll(PDO::FETCH_OBJ);
            UserActivity($_SESSION['member']->id, $_SESSION['member']->nombre.' - Solicito su registro de actividad.', $pdo);
        
            return $log;
        }else{
            return 0;
        }
    }else{
        echo'<script type="text/javascript">
        alert("Lo sentimos, no tienes permiso para esta operación.");
        window.location.href="./?User";
        </script>';
    }

}

#Lectura de actividad Usuario Sys individual
function UserActivity_MyLog($sys_uID, $pdo){
    if(in_array('R_Logs', $_SESSION['user']->perm)){

        $_activity = "SELECT * FROM `sys_user_activity` WHERE `user_id` = '$sys_uID' ORDER BY `accion_id` DESC ";
        
        $activity = $pdo->prepare($_activity);            
        $activity->execute() or die(implode(' >> ', $activity->errorInfo()));

        if($activity->rowCount() > 0 ){
            $log = $activity->fetchAll(PDO::FETCH_OBJ);
        
            return $log;
        }else{
            return "Sin registros para mostrar";
        }
    }else{
        echo'<script type="text/javascript">
        alert("Lo sentimos, no tienes permiso para esta operación.");
        window.location.href="./?Home";
        </script>';
    }

}

### Registro de visitas al blog
function BlogActivity($user_id, $uri, $pdo){
    $ip_address = getRealIP();
    $date_access = time();
    $session_id = session_id();
    
    #quede en crear funcion para registrar actividad de administradores dentro de Blog 
    if(isset($_SESSION['member'])){

    }elseif(isset($_SESSION['user']))

    $_activity = "INSERT INTO `_visitas_al_site` (`user_id`, `session_id`, `ip_address`, `uri`, `fecha`) VALUES ('$user_id', '$session_id', '$ip_address', '$uri', '$date_access')";
    
    $visit = $pdo->prepare($_activity);            
    $visit->execute() or die(implode(' >> ', $visit->errorInfo()));
}

## Registro actividades referidos
function referido_action($user_id, $pdo){
    UserActivity(0, 'Usuario Guet a visitado el sitio usando comando GET (ref='.$user_id.').', $pdo);

    $uri = $_SERVER["REQUEST_URI"];
    $session_id = session_id();
    $ip = getRealIP();
    $date_access = time();

    #Validad si usuario existe
    $query = "SELECT id FROM _miembros WHERE `id` = :id";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':id', $user_id);
    $stmt->execute() or die(implode(' >> ', $stmt->errorInfo()));

    if($stmt->rowCount() > 0 ){

        $user = $stmt->fetch(PDO::FETCH_OBJ);

        $_activity = "INSERT INTO `_log_referidos` (`ip_address_user_assing`, `session_id`, `ref_uri`, `id_mREF`, `fecha`)
                                VALUES ('$ip', '$session_id', '$uri', '$user_id', '$date_access')";

        $activity = $pdo->prepare($_activity);                
        $activity->bindParam(':user_id', $user_id); 
        $activity->execute() or die(implode(' >> ', $activity->errorInfo()));
    }

}



/*

# Funcion para comprobar credenciales de incio de sesion.
function userLogin($username, $password, $pdo){
   if(trim($username) == '' or trim($password) == ''){
        UserActivity('0', 'Intento de acceso sin datos.', $pdo);
        header('Location: ../login.php?empty');
        exit;          
    }

    if(is_string($username)){

        $query = "SELECT * FROM users WHERE `username` = :username";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':username', $username);

        $stmt->execute() or die(implode(' >> ', $stmt->errorInfo()));

        if($stmt->rowCount() > 0 ){

            $user = $stmt->fetch(PDO::FETCH_OBJ);
                if($user->block_user == 1){                   
                    openSession(); 
                    $_SESSION['count_login_false'] = 3;  
                        UserActivity($user->id, 'Intento de acceso fallido por "Usuario bloqueado".', $pdo);                   
                }else{
                    if(password_verify($password, $user->password)){
                        openSession();                       
                            
                            $query = "SELECT code FROM profiles_permissions, permissions WHERE id = permissions AND profile = :profile";
                            $stmt = $pdo->prepare($query);
                            $stmt->bindParam(':profile', $user->profile);

                            $stmt->execute() or die(implode(' >> ', $stmt->errorInfo()));

                            $user->perm = array();
                            while($row = $stmt->fetch(PDO::FETCH_OBJ)){
                                $user->perm[] = $row->code;
                            }

                            $date = time();

                            $last_access = "UPDATE `users` SET `last_access` = '$date' WHERE `id` = $user->id";
                            $access = $pdo->prepare($last_access);            
                            $access->execute() or die(implode(' >> ', $access->errorInfo()));

                            #Registrar actividad de usuario                        
                            UserActivity($user->id, 'Acceso correcto al sistema', $pdo);

                            $_SESSION['user'] = $user;
                            return true;                        

                    }else{
                        openSession();            
                        if(!isset($_SESSION['count_login_false'])){
                            $_SESSION['count_login_false'] = 1;
                                UserActivity($user->id, 'Intento acceso fallido 1. '.$user->nombre.'.', $pdo);
                        }else{
                            $_SESSION['count_login_false']++; 
                            UserActivity($user->id, 'Intento acceso fallido '.$_SESSION['count_login_false'].' - '.$user->nombre.'.', $pdo);  
                            if($_SESSION['count_login_false'] = 3){
                                UserActivity($user->id, $user->nombre.' paso a estado BLOQUEADO.', $pdo);
    
                                UserBlock($user->id, $user->block_user, $pdo); 
                                
                                }                                                                                          
                        }
                        
                        return false;
                    }
                }
                

        }else{
            openSession();
                if(!isset($_SESSION['count_login_false'])){
                    $_SESSION['count_login_false'] = 1;
                    UserActivity(0, 'Intento acceso fallido 1. Usuario no encontrado.', $pdo);
                }else{
                    $_SESSION['count_login_false']++;
                    UserActivity(0, 'Intento acceso fallido '. $_SESSION['count_login_false'] .'. Usuario no encontrado.', $pdo);
                }
                if($_SESSION['count_login_false'] == 3){
                    if(isset($user->id)){
                        UserBlock($user->id, $user->block_user, $pdo); 
                    } 
                    UserActivity(0, 'BLOQUEO!! Session ID ('. session_id() .').', $pdo);        
                } 
        
            return false;
        }
    }
    exit;
}

# Funcion para bloquear usuario.
function UserBlock($userid, $estado, $pdo){

    if($estado == 0){
        $query = "UPDATE `users` SET `block_user` = '1' WHERE `id` = $userid" ;
        $u_block = $pdo->prepare($query);
        $u_block->execute() or die(implode(' >> ', $u_block->errorInfo()));

             # Registro actividad Block User
        UserActivity($userid, 'Usuario bloqueado por 3 intentos fallidos.', $pdo);
            $_SESSION['login_block'] = 1;
    }
}

# Registro actividad usuario
function UserActivity($user_id, $activity, $pdo){
    $ip = getRealIP();
    $date_access = time();
    $user_activity = "INSERT INTO `sys_user_activity` (`user_id`, `user_activity`, `date_access`, `ip_address`) VALUES ('$user_id', '$activity', '$date_access', '$ip')";
    
    $activity = $pdo->prepare($user_activity);            
    $activity->execute() or die(implode(' >> ', $activity->errorInfo()));
}

# Registro actividad usuario para mostrar en LogUser
function LogUserActivity($user_id, $pdo){
    $user_log = "SELECT * FROM `sys_user_activity` WHERE `user_id` = '$user_id'";
    
    $activity_log = $pdo->prepare($user_log);            
    $activity_log->execute() or die(implode(' >> ', $activity_log->errorInfo()));

    if($activity_log->rowCount() > 0 ){

        $user = $activity_log->fetch(PDO::FETCH_OBJ);
    }
}

function getRealIP(){

    if (isset($_SERVER["HTTP_CLIENT_IP"]))
    {
        return $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
    {
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
    {
        return $_SERVER["HTTP_X_FORWARDED"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
    {
        return $_SERVER["HTTP_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED"]))
    {
        return $_SERVER["HTTP_FORWARDED"];
    }
    else
    {
        return $_SERVER["REMOTE_ADDR"];
    }

}


*/

?>

