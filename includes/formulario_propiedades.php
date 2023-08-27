<fieldset>
                <legend>Información General</legend>
                <label for="titulo">Titulo: </label>
                <input type="text" 
                        id="titulo" 
                        name="propiedad[titulo]" 
                        placeholder="Titulo Propiedad" 
                        value="<?php echo s($propiedad->titulo); ?>"
                        max="45">

                <label for="precio">Precio: </label>
                <input type="number" 
                        id="precio" 
                        name="propiedad[precio]" 
                        placeholder="Precio Propiedad" 
                        value="<?php echo s($propiedad->precio); ?>"
                        >
                <label for="imagen">Imagen: </label>
                <input type="file" 
                         id="imagen" 
                         accept="image/jpeg, image/png"
                         name="propiedad[imagen]">
                         

                         <?php if($propiedad->imagen) { ?>
                                <img src="/bienesraices_copia/imagenes/<?php echo $propiedad->imagen ?>" class="imagen-small" >
                         <?php } ?>
                         
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion"
                          name="propiedad[descripcion]" 
                          min="50"><?php echo s($propiedad->descripcion); ?></textarea>
            </fieldset>

            <fieldset>
                <legend>Información Propiedad</legend>
                <label for="habitaciones">Habitaciones</label>
                <input type="number" 
                        id="habitaciones" 
                        name="propiedad[habitaciones]" 
                        placeholder="Ej: 1" 
                        min="1" max="9" 
                        value="<?php echo s($propiedad->habitaciones); ?>" >
                <label for="wc">Baños</label>
                <input type="number" 
                        id="wc" 
                        name="propiedad[wc]" 
                        placeholder="Ej: 1" 
                        min="1" 
                        max="9" 
                        value="<?php echo s($propiedad->wc); ?>">
                <label for="estacionamiento">Estacionamiento</label>
                <input type="number" 
                        id="estacionamiento" 
                        name="propiedad[estacionamiento]" 
                        placeholder="Ej: 1" 
                        min="1" 
                        max="9" 
                        value="<?php echo s($propiedad->estacionamiento); ?>">
            </fieldset>
            
               
                </select>