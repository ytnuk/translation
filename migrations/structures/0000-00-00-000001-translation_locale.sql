--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: translation_locale; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE translation_locale (
    id character varying NOT NULL,
    name character varying NOT NULL
);


--
-- Name: translation_locale_id; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY translation_locale
    ADD CONSTRAINT translation_locale_id PRIMARY KEY (id);


--
-- Name: translation_locale_name; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY translation_locale
    ADD CONSTRAINT translation_locale_name UNIQUE (name);


--
-- PostgreSQL database dump complete
--

