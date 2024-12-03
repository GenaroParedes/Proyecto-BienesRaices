<!-- Incluimos el header desde el archivo header.php, por lo tanto ahora 
 no duplicamos nada de codigo ya que lo tenemos en un solo lugar -->
<?php include 'includes/templates/header.php'; ?>

    <main class="contenedor">
        <h1>Contacto</h1>

        <picture>
            <source srcset="build/img/destacada3.webp" type="image/webp">
            <source srcset="build/img/destacada3.jpg" type="image/jpeg">
            <img loading="lazy" src="build/img/destacada3.jpg" alt="Imagen de contacto">
        </picture>

        <h2>Llene el formulario de contacto</h2>

        <form class="formulario">
            <fieldset> <!-- Me permite dividir la informacion en partes distintas -->
                <legend>Información de Contacto</legend> <!-- Titulo de cada area -->

                <label for="nombre">Nombre:</label>
                <input type="text" placeholder="Ingrese su nombre" id="nombre">

                <label for="email">E-mail:</label>
                <input type="email" placeholder="Ingrese su email" id="email">

                <label for="telefono">Teléfono:</label>
                <input type="tel" placeholder="Ingrese su telefono" id="telefono"> <!-- type="tel" es para telefonos -->

                <label for="mensaje">Mensaje:</label>
                <textarea name="" id="mensaje"></textarea>
            </fieldset>

            <fieldset>
                <legend>Información sobre la propiedad</legend>

                <label for="opciones">Compra o vende</label>
                <select id="opciones">
                    <option value="" disabled selected>-- Seleccione --</option> <!-- selected es para que aparezca por defecto --> 
                    <!-- disabled no me deja seleccionar esa opcion, aunque sea la primera que aparezca-->
                    <option value="compra">Compra</option>
                    <option value="vende">Vende</option>
                </select>

                <label for="presupuesto">Precio o Presupuesto</label>
                <input type="number" placeholder="Ingrese su precio o presupuesto" id="presupuesto">
            </fieldset>

            <fieldset>
                <legend>Contacto</legend>
                <p>Como desea ser contactado</p>

                <div class="forma-contacto">
                    <label for="contactar-telefono">Teléfono</label>
                    <input name="contacto" type="radio" value="telefono" id="contactar-telefono">

                    <label for="contactar-email">E-mail</label>
                    <input name="contacto" type="radio" value="email" id="contactar-email">
                    <!-- El name me permite seleccionar uno solo de los radius y no ambos, deben tener el mismo name -->
                </div>

                <p>Si eligió teléfono, elija la fecha y hora</p>
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha">

                <label for="hora">Hora:</label>
                <input type="time" id="hora" min="09:00" max="18:00">
            </fieldset>

            <input type="submit" value="Enviar" class="boton-verde">
        </form>
    </main>
    <?php include 'includes/templates/footer.php'; ?>
