--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.0
-- Dumped by pg_dump version 9.6.0

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: quotes_author; Type: TABLE; Schema: public; Owner: allen
--

CREATE TABLE quotes_author (
    id integer NOT NULL,
    author_last character varying(200),
    author_first character varying(200) NOT NULL,
    author_middle character varying(200),
    CONSTRAINT unique_author_name UNIQUE(author_first, author_middle, author_last)
);


ALTER TABLE quotes_author OWNER TO allen;

--
-- Name: quotes_author_id_seq; Type: SEQUENCE; Schema: public; Owner: allen
--

CREATE SEQUENCE quotes_author_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE quotes_author_id_seq OWNER TO allen;

--
-- Name: quotes_author_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: allen
--

ALTER SEQUENCE quotes_author_id_seq OWNED BY quotes_author.id;


--
-- Name: quotes_dailyquote; Type: TABLE; Schema: public; Owner: allen
--

CREATE TABLE quotes_dailyquote (
    id integer NOT NULL,
    date_used timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    quote_id integer NOT NULL
);


ALTER TABLE quotes_dailyquote OWNER TO allen;

--
-- Name: quotes_dailyquote_id_seq; Type: SEQUENCE; Schema: public; Owner: allen
--

CREATE SEQUENCE quotes_dailyquote_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE quotes_dailyquote_id_seq OWNER TO allen;

--
-- Name: quotes_dailyquote_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: allen
--

ALTER SEQUENCE quotes_dailyquote_id_seq OWNED BY quotes_dailyquote.id;


--
-- Name: quotes_quote; Type: TABLE; Schema: public; Owner: allen
--

CREATE TABLE quotes_quote (
    id integer NOT NULL,
    quote_content text NOT NULL,
    date_added timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    author_id integer,
    genre_id integer NOT NULL,
    source_id integer NOT NULL
);


ALTER TABLE quotes_quote OWNER TO allen;

--
-- Name: quotes_quote_id_seq; Type: SEQUENCE; Schema: public; Owner: allen
--

CREATE SEQUENCE quotes_quote_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE quotes_quote_id_seq OWNER TO allen;

--
-- Name: quotes_quote_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: allen
--

ALTER SEQUENCE quotes_quote_id_seq OWNED BY quotes_quote.id;


--
-- Name: quotes_quotegenre; Type: TABLE; Schema: public; Owner: allen
--

CREATE TABLE quotes_quotegenre (
    id integer NOT NULL,
    name character varying(200) UNIQUE NOT NULL
);


ALTER TABLE quotes_quotegenre OWNER TO allen;

--
-- Name: quotes_quotegenre_id_seq; Type: SEQUENCE; Schema: public; Owner: allen
--

CREATE SEQUENCE quotes_quotegenre_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE quotes_quotegenre_id_seq OWNER TO allen;

--
-- Name: quotes_quotegenre_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: allen
--

ALTER SEQUENCE quotes_quotegenre_id_seq OWNED BY quotes_quotegenre.id;


--
-- Name: quotes_source; Type: TABLE; Schema: public; Owner: allen
--

CREATE TABLE quotes_source (
    id integer NOT NULL,
    title character varying(200) NOT NULL,
    release_date date,
    url character varying(200),
    author_id integer,
    parent_source_id integer,
    source_type_id integer NOT NULL,
    sort_title character varying(200) NOT NULL DEFAULT ''
);


ALTER TABLE quotes_source OWNER TO allen;

--
-- Name: quotes_source_id_seq; Type: SEQUENCE; Schema: public; Owner: allen
--

CREATE SEQUENCE quotes_source_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE quotes_source_id_seq OWNER TO allen;

--
-- Name: quotes_source_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: allen
--

ALTER SEQUENCE quotes_source_id_seq OWNED BY quotes_source.id;


--
-- Name: quotes_sourcetype; Type: TABLE; Schema: public; Owner: allen
--

CREATE TABLE quotes_sourcetype (
    id integer NOT NULL,
    name character varying(200) UNIQUE NOT NULL
);


ALTER TABLE quotes_sourcetype OWNER TO allen;

--
-- Name: quotes_sourcetype_id_seq; Type: SEQUENCE; Schema: public; Owner: allen
--

CREATE SEQUENCE quotes_sourcetype_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE quotes_sourcetype_id_seq OWNER TO allen;

--
-- Name: quotes_sourcetype_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: allen
--

ALTER SEQUENCE quotes_sourcetype_id_seq OWNED BY quotes_sourcetype.id;


--
-- Name: quotes_author id; Type: DEFAULT; Schema: public; Owner: allen
--

ALTER TABLE ONLY quotes_author ALTER COLUMN id SET DEFAULT nextval('quotes_author_id_seq'::regclass);


--
-- Name: quotes_dailyquote id; Type: DEFAULT; Schema: public; Owner: allen
--

ALTER TABLE ONLY quotes_dailyquote ALTER COLUMN id SET DEFAULT nextval('quotes_dailyquote_id_seq'::regclass);


--
-- Name: quotes_quote id; Type: DEFAULT; Schema: public; Owner: allen
--

ALTER TABLE ONLY quotes_quote ALTER COLUMN id SET DEFAULT nextval('quotes_quote_id_seq'::regclass);


--
-- Name: quotes_quotegenre id; Type: DEFAULT; Schema: public; Owner: allen
--

ALTER TABLE ONLY quotes_quotegenre ALTER COLUMN id SET DEFAULT nextval('quotes_quotegenre_id_seq'::regclass);


--
-- Name: quotes_source id; Type: DEFAULT; Schema: public; Owner: allen
--

ALTER TABLE ONLY quotes_source ALTER COLUMN id SET DEFAULT nextval('quotes_source_id_seq'::regclass);


--
-- Name: quotes_sourcetype id; Type: DEFAULT; Schema: public; Owner: allen
--

ALTER TABLE ONLY quotes_sourcetype ALTER COLUMN id SET DEFAULT nextval('quotes_sourcetype_id_seq'::regclass);


CREATE OR REPLACE FUNCTION proc_quotes_source_sort_title() RETURNS TRIGGER AS $trigger_quotes_source_sort_title$
    BEGIN
        NEW.sort_title = lower(regexp_replace(NEW.title, '^the\s+', '', 'i'));
        RETURN NEW;
    END;
$trigger_quotes_source_sort_title$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_quotes_source_sort_title
    BEFORE INSERT OR UPDATE ON quotes_source
    FOR EACH row
    EXECUTE PROCEDURE proc_quotes_source_sort_title();


CREATE OR REPLACE FUNCTION proc_quote_attribution_check() RETURNS TRIGGER AS $trigger_check_quote_is_attributed$
    DECLARE
        v_quote_source quotes_source%ROWTYPE;
        v_parent_source quotes_source%ROWTYPE;
    BEGIN
        --don't need to do anything if author_id is set
        IF NEW.author_id IS NOT NULL THEN
            RETURN NEW;
        END IF;


        SELECT * from quotes_source INTO v_quote_source WHERE id = NEW.source_id LIMIT 1;

        --don't need to do anything if source has an author directly
        IF v_quote_source.author_id IS NOT NULL THEN
            RETURN NEW;
        END IF;
        
        -- check if source has either author or parent source
        IF v_quote_source.parent_source_id IS NULL THEN
            RAISE EXCEPTION 'If quote doesn''t have an author then quote source must have either an author or parent source';
        END IF;

        -- if quote has parent source and no author, make sure parent source has author
        SELECT * FROM quotes_source INTO v_parent_source WHERE id = v_quote_source.parent_source_id LIMIT 1;
        IF v_parent_source.author_id IS NULL THEN
            RAISE EXCEPTION 'Parent source of quote source must have an author';
        END IF;

        RETURN NEW;
    END;
$trigger_check_quote_is_attributed$ LANGUAGE plpgsql;


-- makes sure either quote source has an author
-- or that parent source of quote source has author
-- arbitrarily long links of sources to parent sources are not allowed
CREATE TRIGGER trigger_check_quote_is_attributed
    BEFORE INSERT OR UPDATE ON quotes_quote
    FOR EACH row
    EXECUTE PROCEDURE proc_quote_attribution_check();



--
-- Name: quotes_author quotes_author_pkey; Type: CONSTRAINT; Schema: public; Owner: allen
--

ALTER TABLE ONLY quotes_author
    ADD CONSTRAINT quotes_author_pkey PRIMARY KEY (id);


--
-- Name: quotes_dailyquote quotes_dailyquote_pkey; Type: CONSTRAINT; Schema: public; Owner: allen
--

ALTER TABLE ONLY quotes_dailyquote
    ADD CONSTRAINT quotes_dailyquote_pkey PRIMARY KEY (id);


--
-- Name: quotes_quote quotes_quote_pkey; Type: CONSTRAINT; Schema: public; Owner: allen
--

ALTER TABLE ONLY quotes_quote
    ADD CONSTRAINT quotes_quote_pkey PRIMARY KEY (id);


--
-- Name: quotes_quotegenre quotes_quotegenre_pkey; Type: CONSTRAINT; Schema: public; Owner: allen
--

ALTER TABLE ONLY quotes_quotegenre
    ADD CONSTRAINT quotes_quotegenre_pkey PRIMARY KEY (id);


--
-- Name: quotes_source quotes_source_pkey; Type: CONSTRAINT; Schema: public; Owner: allen
--

ALTER TABLE ONLY quotes_source
    ADD CONSTRAINT quotes_source_pkey PRIMARY KEY (id);


--
-- Name: quotes_sourcetype quotes_sourcetype_pkey; Type: CONSTRAINT; Schema: public; Owner: allen
--

ALTER TABLE ONLY quotes_sourcetype
    ADD CONSTRAINT quotes_sourcetype_pkey PRIMARY KEY (id);


--
-- Name: quotes_dailyquote_9c7b8123; Type: INDEX; Schema: public; Owner: allen
--

CREATE INDEX quotes_dailyquote_9c7b8123 ON quotes_dailyquote USING btree (quote_id);


--
-- Name: quotes_quote_080a38f3; Type: INDEX; Schema: public; Owner: allen
--

CREATE INDEX quotes_quote_080a38f3 ON quotes_quote USING btree (genre_id);


--
-- Name: quotes_quote_0afd9202; Type: INDEX; Schema: public; Owner: allen
--

CREATE INDEX quotes_quote_0afd9202 ON quotes_quote USING btree (source_id);


--
-- Name: quotes_quote_4f331e2f; Type: INDEX; Schema: public; Owner: allen
--

CREATE INDEX quotes_quote_4f331e2f ON quotes_quote USING btree (author_id);


--
-- Name: quotes_source_4f331e2f; Type: INDEX; Schema: public; Owner: allen
--

CREATE INDEX quotes_source_4f331e2f ON quotes_source USING btree (author_id);


--
-- Name: quotes_source_66a57ec4; Type: INDEX; Schema: public; Owner: allen
--

CREATE INDEX quotes_source_66a57ec4 ON quotes_source USING btree (parent_source_id);


--
-- Name: quotes_source_ed5cb66b; Type: INDEX; Schema: public; Owner: allen
--

CREATE INDEX quotes_source_ed5cb66b ON quotes_source USING btree (source_type_id);


--
-- Name: quotes_dailyquote quotes_dailyquote_quote_id_341cd0a1_fk_quotes_quote_id; Type: FK CONSTRAINT; Schema: public; Owner: allen
--

ALTER TABLE ONLY quotes_dailyquote
    ADD CONSTRAINT quotes_dailyquote_quote_id_341cd0a1_fk_quotes_quote_id FOREIGN KEY (quote_id) REFERENCES quotes_quote(id) DEFERRABLE INITIALLY DEFERRED;


--
-- Name: quotes_quote quotes_quote_author_id_201a84c4_fk_quotes_author_id; Type: FK CONSTRAINT; Schema: public; Owner: allen
--

ALTER TABLE ONLY quotes_quote
    ADD CONSTRAINT quotes_quote_author_id_201a84c4_fk_quotes_author_id FOREIGN KEY (author_id) REFERENCES quotes_author(id) DEFERRABLE INITIALLY DEFERRED;


--
-- Name: quotes_quote quotes_quote_genre_id_30a0712a_fk_quotes_quotegenre_id; Type: FK CONSTRAINT; Schema: public; Owner: allen
--

ALTER TABLE ONLY quotes_quote
    ADD CONSTRAINT quotes_quote_genre_id_30a0712a_fk_quotes_quotegenre_id FOREIGN KEY (genre_id) REFERENCES quotes_quotegenre(id) DEFERRABLE INITIALLY DEFERRED;


--
-- Name: quotes_quote quotes_quote_source_id_cf5d821a_fk_quotes_source_id; Type: FK CONSTRAINT; Schema: public; Owner: allen
--

ALTER TABLE ONLY quotes_quote
    ADD CONSTRAINT quotes_quote_source_id_cf5d821a_fk_quotes_source_id FOREIGN KEY (source_id) REFERENCES quotes_source(id) DEFERRABLE INITIALLY DEFERRED;


--
-- Name: quotes_source quotes_source_author_id_dca72424_fk_quotes_author_id; Type: FK CONSTRAINT; Schema: public; Owner: allen
--

ALTER TABLE ONLY quotes_source
    ADD CONSTRAINT quotes_source_author_id_dca72424_fk_quotes_author_id FOREIGN KEY (author_id) REFERENCES quotes_author(id) DEFERRABLE INITIALLY DEFERRED;


--
-- Name: quotes_source quotes_source_parent_source_id_b6e2b361_fk_quotes_source_id; Type: FK CONSTRAINT; Schema: public; Owner: allen
--

ALTER TABLE ONLY quotes_source
    ADD CONSTRAINT quotes_source_parent_source_id_b6e2b361_fk_quotes_source_id FOREIGN KEY (parent_source_id) REFERENCES quotes_source(id) DEFERRABLE INITIALLY DEFERRED;


--
-- Name: quotes_source quotes_source_source_type_id_9a356450_fk_quotes_sourcetype_id; Type: FK CONSTRAINT; Schema: public; Owner: allen
--

ALTER TABLE ONLY quotes_source
    ADD CONSTRAINT quotes_source_source_type_id_9a356450_fk_quotes_sourcetype_id FOREIGN KEY (source_type_id) REFERENCES quotes_sourcetype(id) DEFERRABLE INITIALLY DEFERRED;


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

GRANT ALL ON SCHEMA public TO allen;


--
-- PostgreSQL database dump complete
--

