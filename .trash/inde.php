<?php

        // foreach ($permissions as $permission) {
        //     if ($authGuard->user()->can($permission)) {
        //         return $next($request);
        //     }
        // }

        // throw UnauthorizedException::forPermissions($permissions);






        $crawler->filter('.card__inner')->each(function ($node) use (&$data) {
            
                $data['title'] = $node->filter('.card__title')->text();
                $data['description'] = $node->filter('.card__excerpt')->text();
                $data['author'] = $node->filter('.card__author')->text();
                $data['date'] = $node->filter('.card__date')->text();
                $data['pages'] = $node->filter('.card__pages')->text();
                $data['image'] = $node->filter('.card__image img')->attr('src');
                // $data['link'] = $node->filter('.card__image')->attr('href');
            });
            
    
            return $data;