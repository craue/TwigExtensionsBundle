# Upgrade from 1.0.x to 2.0

## Function `craue_cloneForm`

- Passing a `FormView` instance is no longer supported. You'll have to pass its underlying `Form` instance instead, i.e. remove the `createView` call in your action.

	before:
	```php
	// in your action
	return $this->render('MyCompanyMyBundle:MyStuff:myTemplate.html.twig', array(
		'form' => $form->createView(),
	));

	// in your template
	{{ form_widget(cloneForm(form)) }}
	```

	after:
	```php
	// in your action
	return $this->render('MyCompanyMyBundle:MyStuff:myTemplate.html.twig', array(
		'form' => $form,
	));

	// in your template
	{{ form_widget(cloneForm(form)) }}
	```
