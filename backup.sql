CREATE TABLE public.user_info
(
    email text NOT NULL,
    passw text NOT NULL,
    fname text NOT NULL,
    phone_no text,
    PRIMARY KEY (email)
)
WITH (
    OIDS = FALSE
);
