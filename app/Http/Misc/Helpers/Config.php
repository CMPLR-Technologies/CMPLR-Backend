<?php

namespace App\Http\Misc\Helpers;

class Config
{
	const PAGINATION_LIMIT = 15;
	const PAGINATION_LIMIT_MIN = 12;
	const API_PAGINATION_LIMIT=10;
	const CACHE_TTL=60*60; // 60seconds * 60 min (1hour)
    const EXPIRE =10;
	const PAGINATION_BLOGS_LIMIT = 15; 
	const Message_PAGINATION_LIMIT =10 ;



	// upload 
	const ALLOWED_EXTESIONS = ['png','jpg','png','jpeg','gif','svg'];
	const IMAGE_PATH = 'images/';
	const MAX_IMAGE_SIZE = 5048;
}