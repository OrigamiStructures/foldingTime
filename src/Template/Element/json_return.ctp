<?php
/**
 * Handle and render json for javascript responses
 * 
 * @param string $element the name (path) to the element to be rendered
 * @param boolean $result
 */

if($success){
    $result = $this->element($element);
} else {
    $result = $this->Flash->render('flash', ['element' => $element]);
}

$return = [
    'success' => $success,
    'result' => $result
];

echo json_encode($return);