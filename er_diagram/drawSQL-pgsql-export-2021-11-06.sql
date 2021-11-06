CREATE TABLE "user"(
    "id" INTEGER NOT NULL,
    "email" TEXT NOT NULL,
    "passoword" TEXT NOT NULL,
    "first_name" TEXT NOT NULL,
    "last_name" TEXT NOT NULL,
    "following_count" INTEGER NOT NULL,
    "likes_count" INTEGER NOT NULL,
    "default_post_format" TEXT NOT NULL,
    "login_options" TEXT NOT NULL,
    "email_activity_check" BOOLEAN NOT NULL,
    "TFA" BOOLEAN NOT NULL,
    "filter_tags" JSON NOT NULL,
    "endless_scrolling" BOOLEAN NOT NULL,
    "show_badge" BOOLEAN NOT NULL,
    "text_editor" TEXT NOT NULL,
    "msg_sound" BOOLEAN NOT NULL,
    "best_stuff_first" BOOLEAN NOT NULL,
    "include_followed_tag" BOOLEAN NOT NULL,
    "tumblr_news" BOOLEAN NOT NULL,
    "conversational_notification" BOOLEAN NOT NULL,
    "filtering_content" JSON NOT NULL
);
ALTER TABLE
    "user" ADD PRIMARY KEY("id");
ALTER TABLE
    "user" ADD CONSTRAINT "user_email_unique" UNIQUE("email");
CREATE TABLE "Posts"(
    "id" INTEGER NOT NULL,
    "blog_id" INTEGER NOT NULL,
    "type" TEXT NOT NULL,
    "content" jsonb NOT NULL,
    "layout" JSON NOT NULL,
    "url" TEXT NOT NULL,
    "date" DATE NOT NULL,
    "timestamp" TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
    "format" TEXT NOT NULL,
    "source_url" TEXT NOT NULL,
    "reblog_key" INTEGER NOT NULL,
    "blog_name" TEXT NOT NULL,
    "mobile" BOOLEAN NOT NULL,
    "source_title" TEXT NOT NULL,
    "post_state" TEXT NOT NULL,
    "parent_post_id" INTEGER NOT NULL,
    "parent_blog_id" INTEGER NOT NULL,
    "post_ask_submit" TEXT NOT NULL,
    "target_user_id" INTEGER NOT NULL,
    "is_anonymous" BOOLEAN NOT NULL,
    "is_apporved" BOOLEAN NOT NULL,
    "post_summary" TEXT NOT NULL
);
ALTER TABLE
    "Posts" ADD PRIMARY KEY("id");
CREATE INDEX "posts_blog_id_index" ON
    "Posts"("blog_id");
COMMENT
ON COLUMN
    "Posts"."parent_blog_id" IS 'connect to id in blog table';
CREATE TABLE "Blog"(
    "id" INTEGER NOT NULL,
    "user_id" INTEGER NOT NULL,
    "name" TEXT NOT NULL,
    "url" TEXT NOT NULL,
    "title" TEXT NOT NULL,
    "primary" BOOLEAN NOT NULL,
    "followers" INTEGER NOT NULL,
    "type" TEXT NOT NULL,
    "password" TEXT NOT NULL,
    "full_priveleges" BOOLEAN NOT NULL,
    "contributor_priveleges" BOOLEAN NOT NULL
);
ALTER TABLE
    "Blog" ADD PRIMARY KEY("id");
CREATE TABLE "BlogSetting"(
    "blog_id" INTEGER NOT NULL,
    "repiles" BOOLEAN NOT NULL,
    "allow_ask" BOOLEAN NOT NULL,
    "ask_page_title" BOOLEAN NOT NULL,
    "allow_anonymous_question" BOOLEAN NOT NULL,
    "allow_submissions" BOOLEAN NOT NULL,
    "submission_page_title" TEXT NOT NULL,
    "submission_guidelines" TEXT NOT NULL,
    "is_text_allowed" BOOLEAN NOT NULL,
    "is_photo_allowed" BOOLEAN NOT NULL,
    "is_link_allowed" BOOLEAN NOT NULL,
    "is_quote_allowed" BOOLEAN NOT NULL,
    "is_video_allowed" BOOLEAN NOT NULL,
    "allow_messaging" BOOLEAN NOT NULL,
    "posts_per_day" INTEGER NOT NULL,
    "posts_start" INTEGER NOT NULL,
    "posts_end" INTEGER NOT NULL,
    "dashboard_hide" BOOLEAN NOT NULL,
    "search_hide" BOOLEAN NOT NULL,
    "header_image" TEXT NOT NULL,
    "avatar" TEXT NOT NULL,
    "avatar_shape" TEXT NOT NULL,
    "background_color" TEXT NOT NULL,
    "accent_color" TEXT NOT NULL,
    "show_header_image" BOOLEAN NOT NULL,
    "stretch_header_image" BOOLEAN NOT NULL,
    "show_avatar" BOOLEAN NOT NULL,
    "show_title" BOOLEAN NOT NULL,
    "show_description" BOOLEAN NOT NULL,
    "use_new_post_type" BOOLEAN NOT NULL,
    "url_handling" BOOLEAN NOT NULL,
    "layout" TEXT NOT NULL,
    "sliding_header" BOOLEAN NOT NULL,
    "show_navigation" BOOLEAN NOT NULL
);
ALTER TABLE
    "BlogSetting" ADD PRIMARY KEY("blog_id");
CREATE TABLE "notification"(
    "id" INTEGER NOT NULL,
    "type" TEXT NOT NULL,
    "timestamp" TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
    "targetBlogId" INTEGER NOT NULL,
    "fromBlogId" INTEGER NOT NULL,
    "targetPostId" INTEGER NOT NULL,
    "mediaURl" TEXT NOT NULL,
    "addedText" TEXT NOT NULL,
    "is_anonymous" BOOLEAN NOT NULL
);
ALTER TABLE
    "notification" ADD PRIMARY KEY("id");
CREATE TABLE "User_follow_Blog"(
    "user_id" INTEGER NOT NULL,
    "blog_id" INTEGER NOT NULL
);
ALTER TABLE
    "User_follow_Blog" ADD PRIMARY KEY("user_id");
ALTER TABLE
    "User_follow_Blog" ADD PRIMARY KEY("blog_id");
CREATE TABLE "Blog_Block"(
    "blog_id" INTEGER NOT NULL,
    "blocked_blog_id" INTEGER NOT NULL
);
ALTER TABLE
    "Blog_Block" ADD PRIMARY KEY("blog_id");
ALTER TABLE
    "Blog_Block" ADD PRIMARY KEY("blocked_blog_id");
CREATE TABLE "Tags"(
    "id" INTEGER NOT NULL,
    "name" TEXT NOT NULL,
    "slug" TEXT NOT NULL
);
ALTER TABLE
    "Tags" ADD PRIMARY KEY("id");
ALTER TABLE
    "Tags" ADD CONSTRAINT "tags_name_unique" UNIQUE("name");
CREATE TABLE "User_tag"(
    "user_id" INTEGER NOT NULL,
    "tags_id" INTEGER NOT NULL
);
ALTER TABLE
    "User_tag" ADD PRIMARY KEY("user_id");
ALTER TABLE
    "User_tag" ADD PRIMARY KEY("tags_id");
CREATE TABLE "posts_tags"(
    "post_id" INTEGER NOT NULL,
    "tags_id" INTEGER NOT NULL
);
ALTER TABLE
    "posts_tags" ADD PRIMARY KEY("post_id");
ALTER TABLE
    "posts_tags" ADD PRIMARY KEY("tags_id");
CREATE TABLE "user_like"(
    "user_id" INTEGER NOT NULL,
    "post_id" INTEGER NOT NULL
);
ALTER TABLE
    "user_like" ADD PRIMARY KEY("user_id");
ALTER TABLE
    "user_like" ADD PRIMARY KEY("post_id");
CREATE TABLE "user_reply"(
    "user_id" INTEGER NOT NULL,
    "post_id" INTEGER NOT NULL,
    "content" TEXT NOT NULL
);
ALTER TABLE
    "user_reply" ADD PRIMARY KEY("user_id");
ALTER TABLE
    "user_reply" ADD PRIMARY KEY("post_id");
CREATE TABLE "chat"(
    "from_blog_id" INTEGER NOT NULL,
    "to_blog_id" INTEGER NOT NULL,
    "content" jsonb NOT NULL
);
ALTER TABLE
    "chat" ADD PRIMARY KEY("from_blog_id");
ALTER TABLE
    "chat" ADD PRIMARY KEY("to_blog_id");
ALTER TABLE
    "Blog" ADD CONSTRAINT "blog_user_id_foreign" FOREIGN KEY("user_id") REFERENCES "user"("id");
ALTER TABLE
    "Posts" ADD CONSTRAINT "posts_parent_post_id_foreign" FOREIGN KEY("parent_post_id") REFERENCES "Posts"("id");
ALTER TABLE
    "Posts" ADD CONSTRAINT "posts_blog_id_foreign" FOREIGN KEY("blog_id") REFERENCES "Blog"("id");
ALTER TABLE
    "notification" ADD CONSTRAINT "notification_targetblogid_foreign" FOREIGN KEY("targetBlogId") REFERENCES "Blog"("id");
ALTER TABLE
    "notification" ADD CONSTRAINT "notification_fromblogid_foreign" FOREIGN KEY("fromBlogId") REFERENCES "Blog"("id");
ALTER TABLE
    "notification" ADD CONSTRAINT "notification_targetpostid_foreign" FOREIGN KEY("targetPostId") REFERENCES "Posts"("id");