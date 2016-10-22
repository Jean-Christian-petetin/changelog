<?php



namespace AppBundle\Controller;

use AppBundle\Entity\News;
use AppBundle\Form\NewsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;



class CrudController extends Controller{
    /**
     * @Route("/admin/form", name="addNews")
     * @Template(":default:addNews.html.twig")
     */
    public function getNews() {
        //On appele le formulaire et on crée une nouvelles instance.
        $f = $this->createForm(NewsType::class, new News());
        return array("formAddNews" => $f->createView());
    }
    
    /**
     * @Route("/administration/add", name="valid")
     */
    public function addNews(Request $request){
        //On crée une nouvelle instance.
        $addNews = new News();
        //On crée un formulaire (une zone en memoire tampon est attibuer le temps que tout soit envoyé en DB.
        $f = $this->createForm(NewsType::class, $addNews);
        //on lie le formulaire avec les champs de la vue.
        $f->handleRequest($request);
        
        //On appelle l'entity manager de doctrine
        $em = $this->getDoctrine()->getManager();
        //On enregistre en memoire le formulaire remplis.
        $em->persist($addNews);
        //On evoie le tout en DB.
        $em->flush();
        
        //on redirige vers la vue qui affiche les news.
        return $this->redirect($this->generateUrl('admin'));
    }
    
    /**
     * @Route("/Admin/del/{id}", name="suprNews")
     */
    public function delNews($id){
        //On appelle l'entity manager de doctrine
        $em = $this->getDoctrine()->getManager();
        //On recupere l'id de la news que l'on veut supprimer.
        $getId = $em->find("AppBundle:News", $id);
        //On enregistre en memoire le formulaire remplis.
        $em->remove($getId);
        //On evoie le tout en DB.
        $em->flush();
        
        //on redirige vers la vue qui affiche les news.
        return $this->redirect($this->generateUrl('admin'));
    }
    
    /**
     * @Route("/admin/edit/{id}", name="editNews")
     * @Template(":default:modifNews.html.twig")
     */
    public function editNews($id, News $up) {
        //on retourne un formulaire avec les champs remplis correspondant l'id de l'instance.
        return array("formModifNews" => $this->createForm(NewsType::class, $up)->createView(), 'id'=>$id);
    }
    
    /**
     * @Route("/index/update/{id}", name="updateNews")
     */
    public function updateNews(Request $request, News $up) {
        //On apelle l'entity manager de doctrine.
        $em = $this->getDoctrine()->getEntityManager();
        
        //on crée un formulaire que l'on lie avec l'instance que l'on a recuperer en paramettre.
        $f = $this->createForm(NewsType::class,$up);
        //on lie les champs que l'on vient de modifier avec le formulaire
        $f->handleRequest($request);
        
        //On effectue plusieur verifications (champs vide + autres )
        if($f->isValid())
        {
            //On réécrit en mémoire les modifications effectuées
            $em->merge($up);
            //On envoie le tout en DB.
            $em->flush();
            
            //On redirige vers la vue adequate
            return $this->redirectToRoute('admin');
        }
    }
}
