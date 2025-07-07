<?php
$livros = array(
    'livro 1' => array(
        'titulo' => 'Bleach',
        'resumo' => 'xxx',
        'categoria' => 'Aзгo, Comйdia'
    ),
    'livro 2' => array(
        'titulo' => 'Titulo livro 2',
        'resumo' => 'xxx',
        'categoria' => 'Aзгo, Psicolуgico, Romance...'
    ),
    'livro 3' => array(
        'titulo' => 'Titulo livro 3',
        'resumo' => 'xxx',
        'categoria' => 'romance, Vampiros ...'
    )
);
$romances = array();
foreach($livros as $livro => $data) {
    if(stripos($data['categoria'], 'nce') !== false) {
        $romances[] = $livro; 
    }
}
print_r($romances);
?>