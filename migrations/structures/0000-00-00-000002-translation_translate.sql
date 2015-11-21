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
-- Name: translation_translate; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE translation_translate (
    id integer NOT NULL,
    translation_id integer NOT NULL,
    locale_id character varying NOT NULL,
    value text NOT NULL
);


--
-- Name: translation_translate_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE translation_translate_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: translation_translate_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE translation_translate_id_seq OWNED BY translation_translate.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY translation_translate ALTER COLUMN id SET DEFAULT nextval('translation_translate_id_seq'::regclass);


--
-- Name: translation_translate_id; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY translation_translate
    ADD CONSTRAINT translation_translate_id PRIMARY KEY (id);


--
-- Name: translation_translate_translation_id_locale_id; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY translation_translate
    ADD CONSTRAINT translation_translate_translation_id_locale_id UNIQUE (translation_id, locale_id);


--
-- Name: translation_translate_locale_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX translation_translate_locale_id ON translation_translate USING btree (locale_id);


--
-- Name: translation_translate_translation_id; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX translation_translate_translation_id ON translation_translate USING btree (translation_id);


--
-- Name: translation_translate_locale_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY translation_translate
    ADD CONSTRAINT translation_translate_locale_id_fkey FOREIGN KEY (locale_id) REFERENCES translation_locale(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: translation_translate_translation_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY translation_translate
    ADD CONSTRAINT translation_translate_translation_id_fkey FOREIGN KEY (translation_id) REFERENCES translation(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

