<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 09/10/16
 * Time: 11:45
 */

namespace general;


class file {

    /**
     * Permet l'upload d'un fichier
     * @param string $path Chemin vers lequel le fichier doit etre uploadé
     * @param array $file Fichier à uploader
     * @param null|int $size_max Taille Maximal du fichier
     * @param null|string $name Nom du fichier aprés l'upload
     * @param bool $img_needed Si on doit uploader une image
     * @param null|string $extension L'extension que devra avoir le fichier à la fin
     * @param null|string|array $needed_extension Les extensions demandés
     * @return bool
     * @throws \Exception
     */
    static function upload($path,$file,$size_max = null,$name = null,$img_needed = false,$extension = null,$needed_extension = null){

        //Si le chemin et le fichier sont invalides on sort du programme
        if(!is_dir($path) || !is_array($file))
            throw new \Exception('Les données entrées ne sont pas corrects',0);

        //Si le fichier est vide on sort du programme
        if($file['tmp_name'] == "")
            throw new \Exception('Veuillez mettre en ligne un fichier',0);

        //Si il y a une erreur dans le fichier on sort du programme
        if($file['error'] != "")
            throw new \Exception('Erreur :'.$file['error'],2);

        //Si une taille maximum est demandé et que celle-ci n'est pas respecté on revois une erreur
        if(!is_null($size_max) && $file['size'] > $size_max)
            throw new \Exception('La fichier est trop volumineux !',1);

        //Si une image est demandé et que ce n'ai pas le cas on sort du programme
        if($img_needed == true && !self::isIMG($file))
            throw new \Exception('Le fichier n\'est pas une image !',1);

        //Si le fichier n'as l'extension demandé on sort du programme
        if((is_string($needed_extension) && self::file_infos($file)->extension != $needed_extension) || (is_array($needed_extension) && in_array(self::file_infos($file),$needed_extension)))
            throw new \Exception('Le fichier n\'est pas valide !',1);

        //On formate le nom du fichier et on change le nom si un nom précis est demandé
        $file_name = $file['name'];
        if(is_string($name))
            $file_name = $name;
        $file_name = strtr($file_name,
            'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
            'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
        $file_name = preg_replace('/([^.a-z0-9]+)/i', '-', $file_name);

        //On définie le chemin final du fichier
        $file_path = $path.'/'.$file_name;

        //On supprime le fichier précédent s'il existe
        self::delete($file_path);

        //On upload le fichier et on envoi une exception en cas d'echec
        if(!move_uploaded_file($file['tmp_name'],$file_path))
            throw new \Exception('Erreur lors de la mise en ligne du fichier',2);

        //Si un extension est demandé on convertis le fichier, si la conversion echoue on supprime le fichier et on revois un echec
        if(is_string($extension))
            if(!self::convert($file_path,$extension))
            {
                self::delete($file_path);
                throw new \Exception('Erreur lors de la conversion du fichier',2);
            }

        //On retourne la reponse
        return true;
    }

    /**
     * Renvoi les des informations sur le fichier
     * @param array/string $file
     * @return \stdClass
     */
    static function file_infos($file){
        $response = new \stdClass();

        //L'argument est un fichier d'upload
        if(is_array($file))
        {
            if(isset($file['type']))
            {
                $type = explode('/',$file['type']);
                $file['type'] = $type[0];
                $file['extension'] = $type[1];
            }
            unset($file['tmp_name']);
            unset($file['error']);
            foreach($file as $key=>$content)
                $response->$key = $content;
        }

        //L'argument est un chemin de fichier
        if(is_file($file)){
            $infos = pathinfo($file);
            $response->name = $infos['filename'].".".$infos['extension'];
            $type = explode('/',mime_content_type($file));
            $response->type = $type[0];
            $response->size = filesize($file);
            $response->extension = str_replace('.','',$infos['extension']);

        }
        return $response;
    }

    /**
     * Permet de supprimer un fichier
     * @param string $path Chemin vers le fichier à supprimer
     * @return bool Reponse de succés
     */
    static function delete($path){
        if(file_exists($path))
            return unlink($path);
        return true;
    }

    /**
     * Convertis un fichier
     * @param string $path Chemin vers le fichier
     * @param string $extension Extension que devra avoir le fichier convertis
     * @return bool Resultat de la conversion
     */
    static function convert($path,$extension){
        //Récupération des infos du fichier
        $files_infos = self::file_infos($path);

        //Si le fichier a deja l'extension on sort de la fonction
        if($files_infos->extension == $extension)
            return true;

        //On génére le nouveau nom du fichier
        $new_file_name = str_replace($files_infos->extension,$extension,$path);

        //On renomme le fichier et on renvoi le resultat
        return rename($path,$new_file_name);
    }

    /**
     * Determine si un fichier est une image
     * @param array/string $file Fichier ou chemin du fichier à analyser
     * @return bool Réponse si le fichier est une image
     */
    private static function isIMG($file){
        //On récupére les infos sur le fichier
        $files_infos = self::file_infos($file);

        //Retourne la reponse
        return $files_infos->type == "image";
    }

} 