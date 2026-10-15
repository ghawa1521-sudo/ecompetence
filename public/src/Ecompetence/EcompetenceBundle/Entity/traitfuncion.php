<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ecompetence\EcompetenceBundle\Entity;

/**
 * Description of function
 *
 * @author JJK
 */
trait traitfuncion {
   private $tabpere=array();
   public function recurse_tree($domaines,$niveau=0) {
        
        foreach ($domaines as $domaine) {
            echo str_pad("",$niveau,"-").$domaine->getLibDomaine().'<br>';
            if($domaine->getChildren()){
                $niveau+=1;
                $this->recurse_tree($domaine->getChildren(),$niveau);
            }
            
            
        }
        
        //return $result;
    }

 public function tree_recherche_parent($enfants, &$tabpere=[]) {
 
       foreach ($enfants as $enfant)  
       {
        
        if ($enfant->getParent()) {
                //$tabpere[]=$tabpere;
                $tabpere[]=$enfant->getParent()->getId();
                $parent=[];
                $parent[]=$enfant->getParent();
                $this->tree_recherche_parent($parent,$tabpere);
               
        }
        }
             
        return array_unique($tabpere);
    }
    
    function buildTree(array $elements, $parentId = null) {
    $branch = array();
  
    foreach ($elements as $element) {
        if ($element['parent_id'] == $parentId) {         
            $children = $this->buildTree($elements, $element['id']);
            if ($children) {
                $element['childrens'] = $children;
                 //dump($children);
                 //die;
            }
          
            $branch[] = $element;
            
                //die;
        }
    
    }
    return $branch;
}


}
