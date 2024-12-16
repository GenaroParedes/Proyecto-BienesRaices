<?php

namespace App;

class ClasePrincipal {
    // Base de datos - Lo hacemos estatico para tener una unica instancia de la BD
    protected static $db;
    //Creamos un arreglo con los nombre de las columnas en base de datos - Esto nos permite mapear el objeto
    protected static $columnasDB = [''];
    protected static $errores = [];
    /*Este atributo se utiliza para consultar o la tabla vendedores o la tabla propiedades, depende de donde se esté
    llamando el metodo.*/
    protected static $tabla = '';

     // Visibilidad de los atributos - debemos crearlos aqui tambien.
     public $id;
     public $imagen;
     public $titulo;
     public $precio;
     public $descripcion;
     public $habitaciones;
     public $wc;
     public $estacionamiento;
     public $creado;
     public $vendedorId;

    public static function setDb($database) {
        self::$db = $database; //La conexion es siempre la misma por lo tanto no hace falta cambiar el self.
        //Todas las referencias a base de datos quedan con el self.
    }

    public function guardar(){
        if (!is_null($this->id)){
            //Actualizando
            $this->actualizar();
        } else {
            //Creando
            $this->crear();
        }
    }

    public function crear() {
        //Sanitizar los datos
        $abributos = $this->sanitizarDatos();

        //Insertar en la base de datos - El Join es para unir los valores de un arreglo, de esta forma podemos
        //unir los nombres de las columnas con los valores de las columnas
        $query = "INSERT INTO " . static::$tabla . " ( "; //Reemplazo todo lo que este como propiedades, para poder reutilizar el codigo con vendedores tambien
        $query .= join(', ', array_keys($abributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($abributos));
        $query .= " ') ";

        //Se usa self cuando el atributo es estatico / se usa this cuando es un atributo publico
        $resultado = self::$db->query($query);
        //debuguear($resultado); //Si devuelve true se ejecutó correctamente
        if($resultado) {
            //Redireccionar al usuario cuando la propiedad se crea correctamente para que no aprete varias veces el boton
            header('Location: /admin?resultado=1'); 
            //resultado=1 es para que se muestre un mensaje de exito, este se va a mostrar en el index.php
            // en la parte de arriba, donde se hace la consulta de la queryString
        }
    }

    public function actualizar(){
        //Sanitizar los datos
        $abributos = $this->sanitizarDatos();
        //Todo lo siguiente lo hacemos para la query a base de datos
        $valores = [];
        foreach ($abributos as $key => $value){
            $valores[] = "{$key}='{$value}'";
        }
        //El join convierte el array en un string, separando por coma los valores
        $query = "UPDATE " . static::$tabla . " SET "; 
        $query .= join(',', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);
        if($resultado) {
            //Redireccionar al usuario - Le pasamos como resultado un 2 ahora en vez de 1 como en la creacion
            header('Location: /admin?resultado=2'); 
        }
    }

    //Eliminamos un registro
    public function delete(){
        //self::$db->escape_string($this->id) esto lo hacemos para que el usuario no introduzca en la URL algo malicioso,
        //Sin intencion de eliminar sino de atacar, en caso de no pasar un int, el escape_string lo va a identificar.
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        //Si hay resultado, redireccionamos a la misma pagina pero con un resultado=3 en la URL para tomar
        //ese valor y aplicar el mensaje de registro eliminado
        if ($resultado) {
            $this->borrarImagen();
            header('location: /admin?resultado=3');
        }
    }

    //Identificar y unir los atributos de la clase con las columnas de la BD
    public function atributos(){
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarDatos(){
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            //echo $key; //Se imprime el nombre de la columna
            //echo $value; //Se imprime el valor de la columna
            //Sanitizar los datos antes de enviarlos a la BD
            //Todas las referencias o lo relacionado a BD ahora se hace con "self::$db"
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    //Validacion
    public static function getErrores(){
        return static::$errores; //De self a static para tomar los valores de la clase hija que se esta instanciando
    }

    public function validar(){
       static::$errores = []; //creo un array vacio cada ves que entramos al validar para ir llenandolo luego
        return static::$errores;
    }

    public function setImagen($imagen) {
        /*Eliminar la imagen previa en caso de actualizacion de imagen - Comprobamos si existe un id en el objeto
        si existe id es porque estamos actualizando y no creando ya que el id se autoincrementa directamente en BD */
       if(!is_null($this->id)) {
            $this->borrarImagen();
       }
        if($imagen) {
            $this->imagen = $imagen;
        }
    }

    //Elimina archivo - Cuando eliminamos una propiedad, tambien tenemos que eliminar su imagen
    public function borrarImagen(){
        //esto nos da la ruta de la imagen que tenia el objeto.
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        //Si existe el archivo, lo eliminamos
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    //Lista todos los registros
    public static function all(){
/*Ahora para que el atributo $tabla tome el valor que tiene en sus clases hijas, dependiendo la instancia de cual
clase sea la que llama al metodo, esto nos permite reutilizar el codigo mediante la herencia*/
        $query = "SELECT * from " . static::$tabla; //static::tabla va a tomar el valor que tenga $tabla en la instancia de vendedor o propiedad
        //Llamamos la funcion que se encarga de iterar por cada registro
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //Busca un registro por su id
    public static function find($id){
        //Consulta para obtener la propiedad con id pasada por la URL
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = $id";
        $resultado = self::consultarSQL($query);
        //Devuelve el primer objeto del array, en este caso tenemos un solo resultado, 
        //pero lo hacemos para no devolver un array y devolver unicamente ese objeto
        return array_shift($resultado);
    }

    //Lo hago en una funcion aparte para poder reutilizar esta funcion (Consultar, actualizar, etc)
    public static function consultarSQL($query) {
        //Consultar la base de datos
        $resultado = self::$db->query($query);
        //Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            //Por cada registro llamamos la funcion crearObjeto para realizar la conversión, el array debe devolver un lista de objetos
            $array[] = static::crearObjeto($registro);
        }
        //debuguear($array); //Vamos a tener todos los registros de base de datos convertidos en objetos

        //Liberar la memoria
        $resultado->free();

        //Retornar los resultados
        return $array;
    }

    //Es la funcion que vamos a utilizar para convertir los arreglos que nos devuelve la consulta a la BD en objetos.
    //La definimos como protected porque va a ser utilizada dentro de esta clase y no por fuera.
    protected static function crearObjeto($registro) {
        $objeto = new static; //Modificamos el self por static ya que ahora estamos en la clase padre y necesitamos crear instancias de las clases hijas (Ya sea vendedor o propiedad)
        //Recorro el registro y por cada llave ($key = nombreColumna) lo igualamos a su valor ($value = valor para ese registro)
        foreach ($registro as $key => $value ){
            if(property_exists($objeto, $key)){ //Verifica si el objeto $objeto tiene un registro con el nombre igual al valor de $key.
                $objeto -> $key = $value; //Cuando se cumpla que la $key exista, entonces se le asigna su $value
            }
        }
        return $objeto;
    }

    //Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar( $args = []){
        foreach( $args as $key => $value){
            //Aca el $this hace referencia al objeto actual que está en el formulario de actualizacion
            if( property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
                //$key es cada uno de los atributos de la clase               
            }
        }
    }
}