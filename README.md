# 🎉 Proyecto-Final (Tesis): Gestión de Eventos  
**Autor:** Enrique Espinosa  
**Carrera:** Tecnicatura Universitaria en Desarrollo de Software

![Gestión de Eventos](https://via.placeholder.com/800x400.png?text=Gestion+de+Eventos)

---

## 📋 Descripción

Este proyecto forma parte de mi tesis para la **Tecnicatura Universitaria en Desarrollo de Software**.  
Se trata de una aplicación web para la **Gestión de Eventos** desarrollada con las siguientes tecnologías:

- **Laravel**: Para el backend y manejo de la lógica de la aplicación.
- **JavaScript**: Para el desplazamiento visual de las mesas.
- **Ajax**: Para la actualización dinámica de la información y eventos sin recargar la página.
- **HTML y CSS**: Para estructurar y estilizar las vistas.
- **Bootstrap**: Para crear una interfaz responsiva y amigable al usuario.

La funcionalidad principal de la aplicación es la **gestión de invitados** y la **asignación de mesas**. Los usuarios pueden agregar invitados, asignarles mesas, y reorganizarlas mediante una interfaz interactiva **drag & drop**.

---

## 🚀 Funcionalidades

- **Asignación dinámica de mesas**: Mueve y organiza visualmente las mesas según la distribución del salón.
- **Gestión de invitados**: Agrega, edita y organiza invitados con sus respectivos detalles.
- **Interfaz responsiva**: La aplicación se adapta a dispositivos móviles, tablets y computadoras.
- **Modal interactivo**: Gestión avanzada de los invitados con un modal ancho y estilizado.
- **Contenedores informativos**: Muestra información importante sobre los invitados (confirmados, rechazados, etc.).
  
![Interfaz de mesas](https://via.placeholder.com/800x400.png?text=Interfaz+de+Mesas)

---

## 📦 Tecnologías Utilizadas

| Tecnología  | Uso           |
|-------------|----------------|
| Laravel     | Backend        |
| JavaScript  | Funcionalidad Drag & Drop |
| Ajax        | Gestión de eventos dinámicos |
| HTML/CSS    | Estructura y estilo |
| Bootstrap   | Estilos y diseño responsivo |

---

## 📐 Diseño Interactivo

La interfaz de la aplicación ha sido diseñada para ser **amigable y atractiva**, asegurando una experiencia de usuario fluida con las siguientes características:

- **Sidebar** fijo para facilitar la navegación.
- **Drag & Drop** intuitivo de las mesas.
- **Actualización dinámica** de la vista sin necesidad de refrescar la página.
  
![Sidebar de navegación](https://via.placeholder.com/400x300.png?text=Sidebar+de+Navegacion)

---

## 🌐 Animaciones

La aplicación incluye suaves **animaciones CSS** para mejorar la experiencia visual, tales como:

- Deslizamiento de mesas.
- Transiciones suaves al abrir y cerrar modales.
- Efectos de hover en botones y elementos interactivos.

```css
/* Ejemplo de animación */
.mesa {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.mesa:hover {
  transform: scale(1.05);
  box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
}
