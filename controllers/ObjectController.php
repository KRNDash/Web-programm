<?php
require_once "BaseFilmTwigController.php";


class ObjectController extends BaseFilmTwigController {
    public $template = "__object.twig"; // указываем шаблон


    public function getContext(): array
    {
        $context = parent::getContext();

        $query = $this->pdo->prepare("SELECT info, image, title, description, id FROM films_objects WHERE id= :my_id");
        // подвязываем значение в my_id
        $query->bindValue("my_id", $this->params['id']);
        $query->execute();
        $data = $query->fetch();
        
        // передаем описание из БД в контекст
        $context['id'] = $data['id'];
        $context['title'] = $data['title'];
        $context['description'] = $data['description'];

        $context["my_session_message"] = isset($_SESSION['welcome_message']) ? $_SESSION['welcome_message'] : "";
        $context["messages"] = isset($_SESSION['messages']) ? $_SESSION['messages'] : "";


        if (isset($_GET['show'])){
            if(($_GET['show'])=="image"){
                $context['is_image'] = true;
                $context['image'] = $data['image'];
            }
            if(($_GET['show'])=="info"){
                $context['is_info'] = true;
                $context['info'] = $data['info'];
            }
        }

        return $context;
    }
}