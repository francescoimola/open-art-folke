<?php

use Uniform\Form;

return function ($kirby) {
  $form = new Form([
    'email' => [
      'rules' => ['required', 'email'],
      'message' => 'Please enter a valid email address',
    ],
  ]);

  $form->withoutRedirect();

  if ($kirby->request()->is('POST')) {
    $form->webhookAction([
      'url'   => option('zapier.webhook'),
      'json'  => true,
      'only'  => ['email'],
      'params' => [
        'method' => 'POST',
        'data'   => ['source' => 'programme-signup'],
      ],
    ]);
  }

  return compact('form');
};
