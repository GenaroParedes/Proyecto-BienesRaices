 <!-- El ENCTYPE se utiliza SIEMPRE que querramos utilizar archivos en el formulario -->
 <fieldset>
                <legend>Información General</legend>
<!--El atributo name en los inputs son los que toman los valores que el usuario ingresa en el formulario, es decir
cuando tengamos que recuperar esos datos ingresados por el formulario al titulo de la propiedad lo vamos a obtener
por medio del atributo titulo ya que es el valor que tiene el name-->
                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" 
                value="<?php echo sanitizar($propiedad -> titulo); ?>">
                <!--El value="" es para que cuando se envie el formulario y haya un error, no se borren los datos ingresados-->
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio de la Propiedad" 
                value="<?php echo sanitizar($propiedad->precio); ?>">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion"><?php echo sanitizar($propiedad->descripcion) ?></textarea>
                <!--En el textarea tiene que ir entre las etiquetas-->
            </fieldset>

            <fieldset>
                <legend>Información de la propiedad</legend>
                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" 
                value="<?php echo sanitizar($propiedad->habitaciones); ?>">

                <label for="wc">Baños:</label>
                <input type="number" id="wc" placeholder="Ej: 3" name="wc" min="1" max="9" 
                value="<?php echo sanitizar($propiedad->wc); ?>">

                <label for="estacionamiento">Estacionamiento:</label>
                <input type="number" id="estacionamiento" placeholder="Ej: 3" name="estacionamiento" min="1" max="9" 
                value="<?php echo sanitizar($propiedad->estacionamiento); ?>">
            </fieldset>

            <!--<fieldset>
                <legend>Vendedor</legend>
                La seleccion de vendedor tiraba error, por lo que ahora lo borramos pero mas adelante retomamos
                 para resolver esto 
            </fieldset> -->