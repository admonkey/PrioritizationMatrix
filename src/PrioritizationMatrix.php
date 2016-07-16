<?php namespace Puckett\PrioritizationMatrix;

use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Validation;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Twig_Environment;
use Twig_Loader_Filesystem;

class PrioritizationMatrix
{

  /*

      functionName($params = DEFAULTS) returns

      __construct($pdo)
      create_metric([name,weight,scale]) INT $id
      get_metric() string HTML <form>

  */

  private $pdo;
  private $twig;
  private $formFactory;
  private $request;
  private static $default_weight = 100;
  private static $default_scale = 10;

  function __construct($pdo){
    if(!$pdo instanceof \PDO)
      trigger_error(
        'ERROR: PrioritizationMatrix requires a PDO database object.',
        E_USER_ERROR
      );

    $this->pdo = $pdo;
    $this->pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );

    // the Twig file that holds all the default markup for rendering forms
    // this file comes with TwigBridge
    $defaultFormTheme = 'form_div_layout.html.twig';
    $appVariableReflection = new \ReflectionClass('\Symfony\Bridge\Twig\AppVariable');
    $vendorTwigBridgeDir = dirname($appVariableReflection->getFileName());
    // the path to your other templates
    $viewsDir = realpath(__DIR__.'/../views');
    $this->twig = new Twig_Environment(new Twig_Loader_Filesystem(array(
        $viewsDir,
        $vendorTwigBridgeDir.'/Resources/views/Form',
    )));
    $formEngine = new TwigRendererEngine(array($defaultFormTheme));
    $this->twig->addExtension(
        new FormExtension(new TwigRenderer($formEngine))
    );
    $this->twig->addExtension(
        new TranslationExtension(new Translator('en'))
    );
    $formEngine->setEnvironment($this->twig);
    // Set up the Validator component
    $validator = Validation::createValidator();
    // create your form factory as normal
    $this->formFactory = Forms::createFormFactoryBuilder()
        ->addExtension(new HttpFoundationExtension())
        ->addExtension(new ValidatorExtension($validator))
        ->getFormFactory();
    $this->request = Request::createFromGlobals();
  }

  public function create_metric($data){
    $sql = 'CALL pm_create_metric(:name,:weight,:scale)';
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($data);
    return (int)$stmt->fetch()['mid'];
  }

  public function get_metric(){
    $data = ['name'=>'','weight'=>self::$default_weight,'scale'=>self::$default_scale];
    $defaults = $data;
    $formBuilder = $this->formFactory
      ->createNamedBuilder('pm_metric',FormType::class,$defaults)
      ->add("name", TextType::class, [
        'attr' => [
          'maxlength' => 255
        ]
      ])
      ->add("weight", IntegerType::class, [
        'attr' => [
          'min' => 1
        ]
      ])
      ->add("scale", IntegerType::class, [
        'attr' => [
          'min' => 1
        ]
      ]);
    $form = $formBuilder->getForm();
    return $this->twig->render('metric.form.html.twig', array(
        'form' => $form->createView(),
    ));
  }

}
