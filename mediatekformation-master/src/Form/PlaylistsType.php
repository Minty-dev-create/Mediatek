<?php

namespace App\Form;

use App\Entity\Playlist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Formation;

class PlaylistsType extends AbstractType

    {
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            $playlist = $options['data'];
            
            $builder
                ->add('name', TextType::class, ['required' => true])
                ->add('description');
            
            if ($playlist->getId() === null) {
                // Si la playlist est en cours de création, affichez toutes les formations
                $builder->add('formations', EntityType::class, [
                    'class' => Formation::class,
                    'choice_label' => 'title',
                    'multiple' => true,
                    'expanded' => false,
                ]);
            } else {
                // Si la playlist existe déjà, affichez uniquement les formations associées
                $builder->add('formations', EntityType::class, [
                    'class' => Formation::class,
                    'choice_label' => 'title',
                    'multiple' => true,
                    'expanded' => false,
                    'choices' => $playlist->getFormations(),
                ]);
            }
            
            $builder->add('submit', SubmitType::class, ['label' => 'Enregistrer']);
        }
        
    }
