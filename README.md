# kahoot_PHP👩🏻‍💻
Práctica de la asignatura de Desarrollo Web en Entorno Servidor. 
La aplicación consiste en un cuestionario de preguntas/respuesta estilo "Kahoot" con algunas modificaciones.
## Tecnologías y disciplinas utilizadas
- Conexión a Base de Datos con MySQLi
- Comprobación de respuestas mediante PHP
## Funcionamiento
1. Preguntas y respuestas almacenadas en una base de datos🛢️
2. Para poder empezar el cuestionario, el usuario tiene que registrarse mediante un formulario en la BD📝
3. Los nombres de usario de la BD son únicos⚠️. Si el usuario que quiere realizar el cuestionario, ya está presente en la BD bajo el mismo nombre que está indicando en el formulario, se le mostrará un mensaje indicando que modifique el nombre💬
4. En el momento en el que el usuario se registre, se almacenará la hora en la BD 🕑 y comenzará el cuestionario
5. Las preguntas se extraen de la BD para ser mostradas al usuario
6. Sólo se muestran 5 preguntas en el cuestionario
7. Las preguntas se muestran de forma aleatoria y no pueden repetirse, para ello se genera un número random entre los números de los id min y max de las preguntas presentes en la BD, y se muestra la pregunta cuyo id coincida con el número generado
8. El usuario debe acertar la pregunta actual para pasar a la siguiente, es decir, si falla ❌, la pregunta en la que se encuentra volverá a repetirse hasta que la acierte✔️
9. La clasificación/ranking no se realiza en base a una puntuación, puesto que todas las preguntas deben estar acertadas por obligación, sino en base al tiempo que se tarde en completar en cuestionario completo⌛
10. Para el seguimiento de las preguntas mostradas, se realiza mediante un array, que las almacena en base a su id, y mediante campos ocultos en el formulario de respuesta del usuario, que indican el id de la pregunta actual y el array mencionado anteriormente
11. Después de acertar la última pregunta, se registra la hora de finalización del usuario y se calcula el tiempo en segundos que ha tardado en completar el test. A continuación, se redirige al usuario a otra página en la que se muestra la clasificación general con todos los usuarios que han realizaddo el test, de forma descendente (menor tiempo a mayor tiempo) en formato tabla-resumen🏆
