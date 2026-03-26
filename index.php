<?php
// abro el archivo xml donde tengo todos los platos
$xml = simplexml_load_file('data/menu.xml');

// creo un array vacio donde voy a guardar los platos agrupados por tipo
$platosPorSeccion = [];

// recorro todos los platos del xml uno a uno
foreach ($xml->plato as $cadaPlato) {

    // saco el atributo tipo de cada plato (arepas, sopas, etc)
    // necesito poner (string) porque php lo lee como objeto y no como texto
    $queTipo = (string) $cadaPlato['tipo'];

    // meto el plato en el array bajo su tipo
    // el [] al final significa "añadelo al final, no lo sobreescribas"
    $platosPorSeccion[$queTipo][] = $cadaPlato;
}

// aqui defino el nombre visible y el icono de cada seccion
// uso los mismos nombres de tipo que en el xml para que coincidan
$infoSecciones = [
    'arepas'    => ['titulo' => 'Arepas',         'icono' => 'fa-solid fa-circle'],
    'sopas'     => ['titulo' => 'Sopas',          'icono' => 'fa-solid fa-bowl-food'],
    'platos'    => ['titulo' => 'Platos Fuertes', 'icono' => 'fa-solid fa-plate-wheat'],
    'pasapalos' => ['titulo' => 'Pasapalos',      'icono' => 'fa-solid fa-drumstick-bite'],
    'postres'   => ['titulo' => 'Postres',        'icono' => 'fa-solid fa-cake-candles'],
    'bebidas'   => ['titulo' => 'Bebidas',        'icono' => 'fa-solid fa-glass-water'],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Arepera de Caracas</title>

    <!-- iconos de font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- mi css -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<!-- cabecera con el nombre del restaurante -->
<header class="cabecera">
    <h1 class="titulo-grande">La Arepera</h1>
    <h2 class="titulo-pequeno">de Caracas</h2>
    <p class="subtitulo">Cocina venezolana · Auténtica · Caraqueña</p>
</header>

<!-- aqui van todas las secciones del menu en dos columnas -->
<main class="contenedor-menu">

    <?php foreach ($infoSecciones as $tipo => $info): ?>

        <!-- cada seccion tiene la clase con su tipo para poder darle color distinto en css -->
        <section class="seccion <?= $tipo ?>">

            <h3 class="titulo-seccion">
                <i class="<?= $info['icono'] ?>"></i>
                <?= $info['titulo'] ?>
            </h3>

            <ul class="lista-platos">

                <?php foreach ($platosPorSeccion[$tipo] as $cadaPlato): ?>
                <li class="un-plato">

                    <!-- fila con nombre, puntitos y precio -->
                    <div class="fila-nombre-precio">
                        <span class="nombre-plato"><?= $cadaPlato->nombre ?></span>
                        <span class="puntitos"></span>
                        <!-- number_format convierte 6.5 en 6.50, siempre con dos decimales -->
                        <span class="precio-plato"><?= number_format((float) $cadaPlato->precio, 2) ?>€</span>
                    </div>

                    <!-- descripcion del plato -->
                    <p class="descripcion-plato"><?= $cadaPlato->descripcion ?></p>

                    <!-- etiquetas como vegano, sin gluten, etc -->
                    <div class="etiquetas">
                        <?php foreach ($cadaPlato->caracteristicas->categoria as $categoria): ?>

                            <!-- convierto a minusculas para comparar sin problemas de mayusculas -->
                            <?php $texto = strtolower((string) $categoria); ?>

                            <?php if ($texto == 'destacado'):   ?> <span class="etiqueta chef"><i class="fa-solid fa-star"></i> Chef</span>
                            <?php elseif ($texto == 'vegano'):  ?> <span class="etiqueta vegano"><i class="fa-solid fa-seedling"></i> Vegano</span>
                            <?php elseif ($texto == 'vegetariano'): ?> <span class="etiqueta vegano"><i class="fa-solid fa-carrot"></i> Veg</span>
                            <?php elseif ($texto == 'sin gluten'): ?> <span class="etiqueta singluten"><i class="fa-solid fa-wheat-awn-circle-exclamation"></i> S/G</span>
                            <?php elseif ($texto == 'lácteo'):  ?> <span class="etiqueta lacteo"><i class="fa-solid fa-cow"></i> Lácteo</span>
                            <?php elseif ($texto == 'carne'):   ?> <span class="etiqueta carne"><i class="fa-solid fa-drumstick-bite"></i> Carne</span>
                            <?php elseif ($texto == 'pescado'): ?> <span class="etiqueta pescado"><i class="fa-solid fa-fish"></i> Pescado</span>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </div>

                </li>
                <?php endforeach; ?>

            </ul>

        </section>

    <?php endforeach; ?>

</main>

<!-- seccion de alergenos e iconos explicativos -->
<div class="alergenos">
    <h3>
        <i class="fa-solid fa-circle-info"></i>
        Información de alérgenos
    </h3>
    <div class="lista-alergenos">
        <span class="alergeno chef">
            <i class="fa-solid fa-star"></i> Recomendado chef
        </span>
        <span class="alergeno vegano">
            <i class="fa-solid fa-seedling"></i> Vegano
        </span>
        <span class="alergeno vegano">
            <i class="fa-solid fa-carrot"></i> Vegetariano
        </span>
        <span class="alergeno singluten">
            <i class="fa-solid fa-wheat-awn-circle-exclamation"></i> Sin gluten
        </span>
        <span class="alergeno lacteo">
            <i class="fa-solid fa-cow"></i> Contiene lácteo
        </span>
        <span class="alergeno carne">
            <i class="fa-solid fa-drumstick-bite"></i> Contiene carne
        </span>
        <span class="alergeno pescado">
            <i class="fa-solid fa-fish"></i> Contiene pescado
        </span>
    </div>
</div>

<!-- pie de pagina con info del restaurante -->
<footer class="pie">
    <i class="fa-solid fa-bowl-food icono-pie"></i>
    <p class="nombre-pie">La Arepera de Caracas</p>
    <p>C/ Venezuela, 12 · Barcelona · +34 632 76 11 19</p>
    <p>Todos los días · 16:00–24:00 y 20:00–24:00</p>
    <p class="texto-promo">¡Pregunta por la promo del día!</p>
</footer>

</body>
</html>
