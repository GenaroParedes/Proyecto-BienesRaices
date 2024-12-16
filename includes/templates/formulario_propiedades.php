 <!-- El ENCTYPE se utiliza SIEMPRE que querramos utilizar archivos en el formulario -->
            <fieldset>
                <legend>Información General</legend>
<!--El atributo name en los inputs son los que toman los valores que el usuario ingresa en el formulario, es decir
cuando tengamos que recuperar esos datos ingresados por el formulario al titulo de la propiedad lo vamos a obtener
por medio del atributo titulo ya que es el valor que tiene el name-->
                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="propiedad[titulo]" placeholder="Titulo Propiedad" 
                value="<?php echo sanitizar($propiedad -> titulo); ?>">
                <!--El value="" es para que cuando se envie el formulario y haya un error, no se borren los datos ingresados-->
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="propiedad[precio]" placeholder="Precio de la Propiedad" 
                value="<?php echo sanitizar($propiedad->precio); ?>">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="propiedad[imagen]">

                <?php if ($propiedad->imagen) { ?>
                    <img src="/imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-small">
                <?php } ?>

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="propiedad[descripcion]"><?php echo sanitizar($propiedad->descripcion) ?></textarea>
                <!--En el textarea tiene que ir entre las etiquetas-->
            </fieldset>

            <fieldset>
                <legend>Información de la propiedad</legend>
                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="habitaciones" name="propiedad[habitaciones]" placeholder="Ej: 3" min="1" max="9" 
                value="<?php echo sanitizar($propiedad->habitaciones); ?>">

                <label for="wc">Baños:</label>
                <input type="number" id="wc" placeholder="Ej: 3" name="propiedad[wc]" min="1" max="9" 
                value="<?php echo sanitizar($propiedad->wc); ?>">

                <label for="estacionamiento">Estacionamiento:</label>
                <input type="number" id="estacionamiento" placeholder="Ej: 3" name="propiedad[estacionamiento]" min="1" max="9" 
                value="<?php echo sanitizar($propiedad->estacionamiento); ?>">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>
                <label for="vendedor">Vendedor</label>
                <select name="propiedad[vendedorId]" id="vendedor">
                    <option selected value="">-- Seleccione --</option>
                    <?php foreach ($vendedores as $vendedor) { ?>
                    <!-- la $propiedad ya trae los valores del $_POST realizado, por lo que si tenemos algun error
                      $propiedad->vendedorId === $vendedor->id ? 'selected' : '' lo anterior 
                      nos permitirá dejar seleccionado el vendedor-->
                        <option <?php echo $propiedad->vendedorId === $vendedor->id ? 'selected' : '';?> value="<?php echo $vendedor->id ?>">
                            <?php echo sanitizar($vendedor->nombre) . " " . sanitizar($vendedor->apellido); ?>
                        </option>
                    <?php } ?>
                </select>
            </fieldset> 