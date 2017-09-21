phpCaptchaForm v0.1a
Fecha de actualización: 19/09/2007
------------------------------------------------------------------------
Archivos incluídos:
	captcha.bg.jpg		- Fondo del captcha
	captcha.font.ttf	- Archivo de fuente trueType para generar el captcha
	captcha.php		- Archivo que muestra el captcha
	error.html		- Archivo a mostrar en caso de error
	formulario.html		- Ejemplo de formulario en html
	gracias.html		- Archivo a mostrar en caso exitoso
	php-captcha.inc.php	- Definición de la clase php-captcha. Para más información visitar sitio oficial: http://www.ejeliot.com/pages/2
	sendmail.php		- Script en php que valida el formulario y envía el mail.
------------------------------------------------------------------------

DEBE leer con atención y respetar cada paso para poder utilizarlo correctamente:

********************
** IMPRESCINDIBLE **
********************

	Edite el archivo 'sendmail.php' con un editor de texto (ascii) como el Bloc de Notas y reemplace, en la segunda línea, la dirección a la que desea que se envíe la información recolectada por el fomulario.
Del archivo sendmail.php no debe modificar nada más, a menos que esté familiarizado con las operaciones a realizar.


********************
**   OPCIONAL     **
********************

)) Cambiar el tamaño del captcha, alto y ancho.
	Para modificar el tamaño del captcha debe abrir el archivo 'captcha.php' y modificar los valores en la línea:
		$oPhpCaptcha = new PhpCaptcha($aFonts, 200, 50);
	Donde 200 y 50 representan el ancho y el alto del captcha.
	Luego deberá modificar el formulario para que muestre una imágen del mismo tamaño en la línea:
		<img src="captcha.php" width="200" height="50" alt="Visual CAPTCHA" />


)) Cambiar el fondo del captcha
	Para modificar la imágen de fondo debe alojar un archivo 'jpg' de 200x60 (o la resolución que hubiera elegido según el paso anterior) y llamarlo 'captcha.bg.jpg', reemplazando as� el actual.


)) Cambiar la fuente del captcha
	Para modificar la fuente debe alojar un archivo de fuente trueType con el nombre 'captcha.font.ttf', reemplazando la actual.

)) Para más información sobre el uso de la clase php-captcha puede visitar el sitio oficial: http://www.ejeliot.com/pages/2

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

A continuación se adjunta el código html de un formulario de ejemplo (ver formulario.html).
Puede modificar este formulario para que se ajuste a sus necesidades, no obstante, los campos 'subject', 'errorOcurred', 'successfully' y 'captcha' deben estar especificados, de otro modo no funcionará correctamente.

<form name="form" method="POST" action="sendmail.php">
	Nombre: <input type="text" name="nombre"><br>
	Teléfono: <input type="text" name="telefono"><br>
	Correo Electrónico: <input type="text" name="email"><br>
	Sugerencia: <textarea rows="4" cols="30" name="Sugerencia"></textarea><br>

	<img src="captcha.php" width="200" height="50" alt="Visual CAPTCHA" /><br>
	Código de Verificación: <input type="text" name="captcha"/><br/>

	<input type="hidden" name="subject" value="Nueva Sugerencia">
	<input type="hidden" name="errorOcurred" value="error.html">
	<input type="hidden" name="successfully" value="gracias.html">

	<input type="submit" value="Enviar Formulario">&nbsp;&nbsp;
	<input type="reset" value="Borrar Datos">
</form>

nota:
    -La imágen y el campo 'captcha' son imprescindibles para el correcto funcionamiento del formulario.
    -Los input de tipo hidden son ocultos al usuario, estos 3 campos son necesarios para el correcto funcionamiento del formulario.
    -El campo 'subject' no tiene que ser necesariamente hidden. Puede ser type="text" para que el usuario complete.
    -El campo 'successfully' representa la pagina a mostrar si la información se ha podido enviar correctamente.
    -El campo 'errorOcurred' representa la pagina a mostrar en caso de que pudiera haber ocurrido algún eventual error.
    -Los nombres de los campos 'subject', 'successfully' y 'errorOcurred' no pueden modificarse. Lo que se puede modificar son los value, para cambiar el asunto, el nombre del archivo a mostrar si se efectuá sin inconvenintes y el nombre del archivo a mostrar si ocurrió algún error.
    -Gracias a que se adapta a cualquier formulario, se pueden implementar más de un formulario en el sitio con un solo sendmail.php.

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Ante cualquier inquietud sobre el uso de este script
en el dominio que tiene alojado con nosotros
no dude en ponerse en contacto
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
