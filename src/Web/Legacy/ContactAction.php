<?php declare(strict_types = 1);

namespace Web\Legacy;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class ContactAction.
 *
 * @package Web\Action
 */
class ContactAction
{
    /**
     * @var Template
     */
    private $template;

    /**
     * IndexAction constructor.
     *
     * @param Template $template template engine
     */
    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    /**
     * Executed when action is invoked.
     *
     * @param  Request       $request  request
     * @param  Response      $response response
     * @param  callable|null $next     next in line
     * @return HtmlResponse
     */
    public function __invoke(Request $request, Response $response, callable $next = null) : HtmlResponse
    {
        $errors = [];
        if (isset($request->getParsedBody()['send'])) {
            $errors = $this->validateRequest($request);
            if (empty($errors)) {
                $this->sendMail($request);
                die('poslao mail');
            }
        }

        $data = [
            'components' => 'zend-*',
            'template'   => 'zend-view',
            'layout' => 'layout::legacy2sidebars',
            'errors' => $errors
        ];

        return new HtmlResponse($this->template->render('legacy::contact', $data));
    }

    protected function sendMail(Request $request)
    {
        $to = 'djavolak@mail.ru';
        $subject = 'phpsrbija.rs :: Nova poruka sa kontakt forme';
        $body = 'Naslov poruke:' . PHP_EOL;
        $body .= $request->getAttribute('subject') . PHP_EOL;
        $body .= $request->getAttribute('message');
        $from = $request->getAttribute('lastName') . '' . $request->getAttribute('email');
        $headers = "From: <{$from}>" . PHP_EOL .
            "Reply-To: <{$from}>" . PHP_EOL;

        if (!mail($to, $subject, $body, $headers)) {
            die('mail could not be sent.');
            throw new \Exception('mail could not be sent.');
        }
    }

    protected function validateRequest(Request $request)
    {
        $data = $request->getParsedBody();

        $errors = [];
        if (strlen($data['message']) < 3) {
            $errors[] = 'Morate uneti tekst poruke.';
        }

        if (strlen($data['lastName']) < 3) {
            $errors[] = 'Morate uneti vaše ime.';
        }

        if (strlen($data['subject']) < 3) {
            $errors[] = 'Morate uneti naslov poruke.';
        }

        $email = $data['email'];
        if (strlen($email) > 3 && !$this->validateMail($email)) {
            $errors[] = 'Morate uneti vašu ispravnu email adresu.';
        }

        //quick anti bot, this is a fake hidden field that user will not fill out.
        if (strlen($data['firstName']) > 0) {
            $errors[] = 'Morate popuniti vašu email adresu.';
        }

        return $errors;
    }

    protected function validateMail($email)
    {
        $validator = new \Zend\Validator\EmailAddress();
        if (!$validator->isValid($email)) {
            return false;
        }

        return true;
    }
}
