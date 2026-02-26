#  Sistema de Gestión de Inventario 



##  Estructura del Proyecto

El sistema está dividido de forma modular, separando cada acción del CRUD en su propio archivo:

* `index.php` -> **Leer :** Ventana principal que lista todos los productos .
* `agregar.php` -> **Crear :** Formulario con retención de datos y validaciones para ingresar nuevo producto.
* `editar.php` -> **Actualizar :** Formulario pre-llenado con protección de la llave primaria .
* `eliminar.php` -> **Eliminar :** Interfaz de confirmación destructiva  .
* `vender.php` -> **Transacción:** Lógica matemática para procesar ventas, validar stock restante y mostrar ticket de compra.
* `css/estilo.css` -> **Diseño:** Variables de colores, gradientes y personalización de componentes de Bootstrap.

---

##  Instrucciones de Instalación y Uso

Para ejecutar este proyecto en tu computadora local, necesitas un servidor web con soporte para PHP (como **WAMP**, XAMPP o Laragon).

### Paso 1: Clonar el repositorio
Abre tu terminal (Símbolo del sistema, PowerShell o Git Bash), navega hasta la carpeta pública de tu servidor web (por ejemplo, `C:\wamp64\www\` en WAMP o `C:\xampp\htdocs\` en XAMPP) y ejecuta el siguiente comando:

```bash
git clone [https://github.com/Chris103105/Investigacion_Aplicada_1_DSS.git](https://github.com/Chris103105/Investigacion_Aplicada_1_DSS.git)

Paso 2: Iniciar el servidor web
Asegúrate de que los servicios de Apache estén corriendo en tu entorno de desarrollo local (WAMP/XAMPP).

Paso 3: Ejecutar la aplicación
Abre tu navegador web de preferencia (Chrome, Firefox, Edge) y navega a la siguiente dirección:


http://localhost/Investigacion_Aplicada_1_DSS/
