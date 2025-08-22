<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="assets/css/index.css">
  <title>MI HIERBAL - ¿Quiénes somos?</title>
</head>
<body>

<header class="header">
  <div class="logo">
    <img src="assets/img/logo.png" alt="Logo MI HIERBAL" />
  </div>
  <nav>
    <ul>
      <li><a href="index.php">Inicio</a></li>
      <li><a href="index.php">Quienes Somos</a></li>
      <li><a href="carrito_compras.php">Comprar Ahora</a></li>
    </ul>
  </nav>
</header>

<section class="bienvenida">
    <div class="texto-bienvenida">
        <h1>¡Bienvenidos<span> Esto es Hieribal </span>!</h1>
        <p>Encuentra todos los productos al mejor precio.</p>
<a href="vista/login_cliente.php" class="btn-ver-todo">Iniciar sesión (Cliente)</a>
<a href="vista/login_usuario.php" class="btn-ver-todo">Modo Administrador</a>
    </div>
    <div class="imagenes-bienvenida">
        <div class="img-card top-left">
            <img src="assets/img/ 1.jpg" alt="Persona 1">
          
        </div>
        <div class="img-card top-right">
            <img src="assets/img/IA 2.jpg" alt="Persona 2">
        </div>
        <div class="img-card bottom-left">
            <img src="assets/img/IA 3.jpg" alt="Persona 3">
            
        </div>
        <div class="img-card bottom-right">
            <img src="assets/img/persona4.jpg" alt="Persona 4">
        </div>
    </div>
</section>


<main class="main-content">
  <section class="text-section">
    <h1>¿Quiénes somos?</h1>
    <p>Somos MI HIERBAL, un oasis de bienestar natural. Creemos que la salud es un viaje, no un destino. Y en cada paso de ese camino, queremos acompañarte con productos naturales de la más alta calidad. En nuestra tienda, encontrarás más que simples productos; encontrarás un compromiso con tu bienestar integral.</p>
    <div class="text-section-buttons">
      <a href="https://wa.me/573212322978?text=Hola%2C%20me%20gustaría%20más%20información%20sobre%20sus%20productos" class="btn btn-contactanos">Contáctanos</a>
      <button class="btn btn-mas-nosotros" onclick="document.getElementById('nosotros').scrollIntoView({ behavior: 'smooth' })">Más sobre nosotros</button>
    </div>
  </section>
  <section class="image-section">
    <img src="" alt="Nature background" />
  </section>
</main>

<section id="nosotros" class="nosotros-section">
  <div class="nosotros-about-section">
    <div>
      <div class="nosotros-text-block">
        <h2>Misión</h2>
        <p>Nuestra misión es mejorar la calidad de vida de nuestros clientes, la salud natural y el equilibrio del cuerpo y la mente, proporcionando productos naturales orgánicos de alta calidad que respetan el medio ambiente asesorando un estilo de vida saludable.</p>
      </div>
      <div class="nosotros-text-block">
        <h2>Visión</h2>
        <p>Ser la droguería naturista líder en la zona, reconocida por nuestra amplia gama de productos naturales orgánicos, nuestro compromiso con la salud y la capacidad para crear soluciones personalizadas para cada cliente.</p>
      </div>
    </div>
    <div>
      <div class="commitment-card">
        <h3>Compromiso</h3>
        <p>Nuestro lema es ser comprometidos de una manera eficiente con nuestros clientes.</p>
      </div>
    </div>
  </div>
</section>

<section class="call-to-action-section">
  <h2>Únete a Nuestra Comunidad Saludable</h2>
  <p>Recibe las últimas noticias, ofertas exclusivas y consejos de bienestar directamente en tu bandeja de entrada.</p>
  <div class="form-container">
    <input type="text" placeholder="Tu Nombre" />
    <input type="email" placeholder="Tu Correo Electrónico" />
    <button type="submit">Suscribirse</button>
  </div>
</section>

</body>
</html>

