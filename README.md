# 🎓 Proyecto-Final (Tesis): Gestión de Eventos  
**Autor:** Enrique Espinosa  
**Carrera:** Tecnicatura Universitaria en Desarrollo de Software

---

![Gestión de Eventos](https://via.placeholder.com/800x400.png?text=Gestion+de+Eventos)

## 📋 Descripción

Este proyecto es parte de mi tesis para la **Tecnicatura Universitaria en Desarrollo de Software**.  
Se trata de una aplicación web completa para la **Gestión de Eventos**, que permite la administración de invitados y la organización visual de mesas utilizando **Laravel** para el backend y varias tecnologías frontend como **JavaScript**, **Ajax**, **HTML**, **CSS**, y **Bootstrap**.

La funcionalidad principal de la aplicación es gestionar invitados y asignarles mesas, con una interfaz visual interactiva que permite reorganizarlas mediante **drag & drop**.

---

## 🚀 Funcionalidades

- 🔄 **Asignación dinámica de mesas**: Organiza visualmente las mesas según la distribución del salón.
- 👥 **Gestión de invitados**: Agrega, edita y organiza invitados con sus detalles.
- 📱 **Interfaz responsiva**: Adaptable a cualquier dispositivo, desde computadoras hasta tablets.
- 💡 **Modal interactivo**: Gestión avanzada de invitados con un diseño visual estilizado y accesible.
- 📊 **Contenedores informativos**: Muestra estadísticas de invitados (confirmados, rechazados, en espera, sin mesa).

---

## 📦 Tecnologías Utilizadas

| Tecnología  | Uso           | Logo |
|-------------|----------------|------|
| Laravel     | Backend y lógica | ![Laravel](https://img.icons8.com/fluency/48/000000/laravel.png) |
| JavaScript  | Funcionalidad Drag & Drop | ![JavaScript](https://img.icons8.com/color/48/000000/javascript.png) |
| Ajax        | Gestión dinámica sin recargar página | ![Ajax](https://img.icons8.com/external-flatart-icons-outline-flatarticons/64/000000/external-ajax-seo-flatart-icons-outline-flatarticons.png) |
| HTML        | Estructura de la web | ![HTML](https://img.icons8.com/color/48/000000/html-5--v1.png) |
| CSS         | Estilos visuales | ![CSS](https://img.icons8.com/color/48/000000/css3.png) |
| Bootstrap   | Diseño responsivo | ![Bootstrap](https://img.icons8.com/color/48/000000/bootstrap.png) |

---

## 🌟 Interactividad y Diseño

El diseño de la aplicación busca proporcionar una experiencia de usuario fluida y atractiva, con las siguientes características:

- 🖱️ **Sidebar** fijo para una navegación más cómoda.
- 🖼️ **Drag & Drop** intuitivo para mover y organizar las mesas.
- 🔄 **Actualización dinámica** de la vista utilizando Ajax, sin recargar la página.

**Animación de desplazamiento de mesas:**

![Animación Drag & Drop](https://via.placeholder.com/800x400.gif?text=Drag+%26+Drop+Animation)

---

## 🌐 Animaciones

La aplicación incluye animaciones suaves en las transiciones para mejorar la experiencia visual:

- ✨ **Deslizamiento suave** de mesas.
- 🎯 **Transiciones** al abrir y cerrar modales.
- 🖱️ **Hover interactivo** en botones y elementos de la interfaz.

**Animación de apertura del modal de invitados:**

![Animación Modal](https://via.placeholder.com/800x400.gif?text=Modal+Animation)

---

## 📸 Capturas de Pantalla

Aquí puedes ver algunas capturas que destacan las principales funcionalidades:

- **Vista general del evento**:
  ![Vista general](https://via.placeholder.com/800x400.png?text=Vista+General)

- **Modal de gestión de invitados**:
  ![Modal de invitados](https://via.placeholder.com/800x400.png?text=Modal+de+Invitados)

---

## 🛠️ Instalación

Para clonar y ejecutar este proyecto en tu máquina local, sigue estos pasos:

```bash
# Clonar el repositorio
git clone https://github.com/QuiqueEspinosa/ProyectoFinal-tesis-.git

# Instalar dependencias
composer install
npm install

# Configurar archivo .env
cp .env.example .env
php artisan key:generate

# Migrar base de datos
php artisan migrate

# Ejecutar el servidor local
php artisan serve
