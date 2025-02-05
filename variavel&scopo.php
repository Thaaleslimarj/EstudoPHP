$x = 10; //global variable
function test() {
    global $x; // accessing the global variable
    echo $x;
}
test(); //prints 10

---------------------------------------------------------------------------------


Exemplo #1 Exemplo de escopo global de variável
<?php
$a = 1;
include 'b.inc'; // Variável $a estará disponível dentro de b.inc
?>

---------------------------------------------------------------------------------

Exemplo #2 Exemplo de escopo local de variável
<?php
$a = 1; // escopo global

function test()
{
    echo $a; // Variável $a é indefinida já que refere-se a uma versão local de $a
}
?>

------------------------------------------------------------------------------

Exemplo #3 Usando global
<?php
$a = 1;
$b = 2;

function Soma()
{
    global $a, $b;

    $b = $a + $b;
}

Soma();
echo $b;
?>

------------------------------------------------------------------------------

Exemplo #4 Usando $GLOBALS no lugar de global
<?php
$a = 1;
$b = 2;

function Soma()
{
    $GLOBALS['b'] = $GLOBALS['a'] + $GLOBALS['b'];
}

Soma();
echo $b;
?>

------------------------------------------------------------------------------
Exemplo #5 Exemplo demonstrando superglobals e escopos
<?php
function test_superglobal()
{
    echo $_POST['name'];
}
?>

---------------------------------------------------------------------------------

Exemplo #6 Exemplo demonstrando a necessidade de variáveis estáticas

<?php
function Teste()
{
    $a = 0;
    echo $a;
    $a++;
}
?>

---------------------------------------------------------------------------------

Exemplo #7 Exemplo de uso de variáveis estáticas

<?php
function Teste()
{
    static $a = 0;
    echo $a;
    $a++;
}
?>

---------------------------------------------------------------------------------

Exemplo #8 Variáveis estáticas em funções recursivas

<?php
function Teste()
{
    static $count = 0;

    $count++;
    echo $count;
    if ($count < 10) {
        Teste();
    }
    $count--;
}
?>

---------------------------------------------------------------------------------

Exemplo #9 Declarando variáveis estáticas

<?php
function foo(){
    static $int = 0;          // correto
    static $int = 1+2;        // correto
    static $int = sqrt(121);  // correto a partir do PHP 8.3

    $int++;
    echo $int;
}
?>

---------------------------------------------------------------------------------

Exemplo #10 Variáveis ​​estáticas em funções anônimas

<?php
function funcaoExemplo($input) {
    $result = (static function () use ($input) {
        static $counter = 0;
        $counter++;
        return "Entrada: $input, Contador: $counter\n";
    });

    return $result();
}

// Chamadas a funcaoExemplo irão recriar a função anônima, de forma que a variável
// estática não reterá seu valor.
echo funcaoExemplo('A'); // Exibe: Entrada: A, Contador: 1
echo funcaoExemplo('B'); // Exibe: Entrada: B, Contador: 1
?>

---------------------------------------------------------------------------------

Exemplo #11 Uso de variáveis estáticas em métodos herdados

<?php
class Foo {
    public static function counter() {
        static $counter = 0;
        $counter++;
        return $counter;
    }
}
class Bar extends Foo {}
var_dump(Foo::counter()); // int(1)
var_dump(Foo::counter()); // int(2)
var_dump(Bar::counter()); // int(3), e antes do PHP 8.1.0 int(1)
var_dump(Bar::counter()); // int(4), e antes do PHP 8.1.0 int(2)
?>

---------------------------------------------------------------------------------

Referências em variáveis global e static ¶

<?php
function test_global_ref() {
    global $obj;
    $new = new stdClass;
    $obj = &$new;
}

function test_global_noref() {
    global $obj;
    $new = new stdClass;
    $obj = $new;
}

test_global_ref();
var_dump($obj);
test_global_noref();
var_dump($obj);
?>

O exemplo acima produzirá:

NULL
object(stdClass)#1 (0) {
}


Um comportamento similar se aplica à declaração static.
Referências não são armazenadas estaticamente:

<?php
function &get_instance_ref() {
    static $obj;

    echo 'Objeto estático: ';
    var_dump($obj);
    if (!isset($obj)) {
        $new = new stdClass;
        // Atribui uma referencia à variável estática
        $obj = &$new;
    }
    if (!isset($obj->property)) {
        $obj->property = 1;
    } else {
        $obj->property++;
    }
    return $obj;
}

function &get_instance_noref() {
    static $obj;

    echo "Objeto estático: ";
    var_dump($obj);
    if (!isset($obj)) {
        $new = new stdClass;
        // Atribui o objeto à variável estática
        $obj = $new;
    }
    if (!isset($obj->property)) {
        $obj->property = 1;
    } else {
        $obj->property++;
    }
    return $obj;
}

$obj1 = get_instance_ref();
$still_obj1 = get_instance_ref();
echo "\n";
$obj2 = get_instance_noref();
$still_obj2 = get_instance_noref();
?>


O exemplo acima produzirá:

Objeto estático: NULL
Objeto estático: NULL

Objeto estático: NULL
Objeto estático: object(stdClass)#3 (1) {
  ["property"]=>
  int(1)
}

Este exemplo demonstra que ao atribuir uma referência a uma variável estática,
ela não será lembrada quando a função &get_instance_ref() for chamada uma segunda vez.