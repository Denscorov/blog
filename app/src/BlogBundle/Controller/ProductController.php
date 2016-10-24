<?php

namespace BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BlogBundle\Entity\Product;
use BlogBundle\Form\ProductType;

/**
 * Product controller.
 *
 * @Route("/product")
 */
class ProductController extends Controller
{
    /**
     * Lists all Product entities.
     *
     * @Route("/", name="product_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('BlogBundle:Product')->findAll();

        return $this->render('BlogBundle:Entity:Product/index.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * Creates a new Product entity.
     *
     * @Route("/new", name="product_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('BlogBundle\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach ($product->getImages() as $image) {
                $image->setFile($this->get('file.processor')->upload($image->getFile()));
                $em->persist($image);
                $product->addImage($image);
            }
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_show', array('id' => $product->getId()));
        }

        return $this->render('BlogBundle:Entity:Product/new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Product entity.
     *
     * @Route("/{id}", name="product_show")
     * @Method("GET")
     */
    public function showAction(Product $product)
    {
//        $deleteForm = $this->createDeleteForm($product);

        return $this->render('BlogBundle:Entity:Product/show.html.twig', array(
            'product' => $product,
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     * @Route("/{id}/edit", name="product_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Product $product)
    {
//        $deleteForm = $this->createDeleteForm($product);
        var_dump($product->getImages()[0]);die;
        $editForm = $this->createForm('BlogBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_edit', array('id' => $product->getId()));
        }

        return $this->render('BlogBundle:Entity:Product/edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Product entity.
     *
     * @Route("/delete/{id}", name="product_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository('BlogBundle:Product')->find($id);
//        $form = $this->createDeleteForm($product);
//        $form->handleRequest($request);

//        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($product);
            $em->flush();
//        }

        return $this->redirectToRoute('product_index');
    }

    //    /**
    //     * Creates a form to delete a Product entity.
    //     *
    //     * @param Product $product The Product entity
    //     *
    //     * @return \Symfony\Component\Form\Form The form
    //     */
    //    private function createDeleteForm(Product $product)
    //    {
    //        return $this->createFormBuilder()
    //            ->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
    //            ->setMethod('DELETE')
    //            ->getForm();
    //    }
}
