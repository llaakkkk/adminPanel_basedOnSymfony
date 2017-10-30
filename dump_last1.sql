--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.5
-- Dumped by pg_dump version 9.6.5

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: admin_user; Type: TABLE; Schema: public; Owner: psqlsymfony
--

CREATE TABLE admin_user (
    id integer NOT NULL,
    username character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    roles json,
    created timestamp(0) without time zone DEFAULT NULL::timestamp without time zone NOT NULL,
    updated timestamp(0) without time zone DEFAULT NULL::timestamp without time zone NOT NULL,
    is_active boolean DEFAULT true NOT NULL
);


ALTER TABLE admin_user OWNER TO psqlsymfony;

--
-- Name: admin_user_id_seq; Type: SEQUENCE; Schema: public; Owner: psqlsymfony
--

CREATE SEQUENCE admin_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE admin_user_id_seq OWNER TO psqlsymfony;

--
-- Name: migration_versions; Type: TABLE; Schema: public; Owner: psqlsymfony
--

CREATE TABLE migration_versions (
    version character varying(255) NOT NULL
);


ALTER TABLE migration_versions OWNER TO psqlsymfony;

--
-- Name: permissions; Type: TABLE; Schema: public; Owner: psqlsymfony
--

CREATE TABLE permissions (
    perm_id integer NOT NULL,
    perm_desc character varying(50) NOT NULL
);


ALTER TABLE permissions OWNER TO psqlsymfony;

--
-- Name: permissions_perm_id_seq; Type: SEQUENCE; Schema: public; Owner: psqlsymfony
--

CREATE SEQUENCE permissions_perm_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE permissions_perm_id_seq OWNER TO psqlsymfony;

--
-- Name: permissions_perm_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: psqlsymfony
--

ALTER SEQUENCE permissions_perm_id_seq OWNED BY permissions.perm_id;


--
-- Name: role_permissions; Type: TABLE; Schema: public; Owner: psqlsymfony
--

CREATE TABLE role_permissions (
    perm_id integer,
    role_id integer,
    role_perm_id integer NOT NULL
);


ALTER TABLE role_permissions OWNER TO psqlsymfony;

--
-- Name: role_permissions_role_perm_id_seq; Type: SEQUENCE; Schema: public; Owner: psqlsymfony
--

CREATE SEQUENCE role_permissions_role_perm_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE role_permissions_role_perm_id_seq OWNER TO psqlsymfony;

--
-- Name: roles; Type: TABLE; Schema: public; Owner: psqlsymfony
--

CREATE TABLE roles (
    role_id integer NOT NULL,
    role_name character varying(255) NOT NULL
);


ALTER TABLE roles OWNER TO psqlsymfony;

--
-- Name: roles_role_id_seq; Type: SEQUENCE; Schema: public; Owner: psqlsymfony
--

CREATE SEQUENCE roles_role_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE roles_role_id_seq OWNER TO psqlsymfony;

--
-- Name: roles_role_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: psqlsymfony
--

ALTER SEQUENCE roles_role_id_seq OWNED BY roles.role_id;


--
-- Name: roles role_id; Type: DEFAULT; Schema: public; Owner: psqlsymfony
--

ALTER TABLE ONLY roles ALTER COLUMN role_id SET DEFAULT nextval('roles_role_id_seq'::regclass);


--
-- Data for Name: admin_user; Type: TABLE DATA; Schema: public; Owner: psqlsymfony
--

INSERT INTO admin_user (id, username, email, password, roles, created, updated, is_active) VALUES (73, 'Lena', 'lena123@admin.com', '$2y$12$A8tO26d0rekZFPr94Hrj1uYYF9sQr.auuAFlX/udOzEfn/2S4dIL.', '["ROLE_SUPPORT"]', '2017-09-22 09:58:05', '2017-09-22 09:58:05', true);
INSERT INTO admin_user (id, username, email, password, roles, created, updated, is_active) VALUES (72, 'admin', 'admin1212@admin.com', '$2y$12$A8tO26d0rekZFPr94Hrj1uYYF9sQr.auuAFlX/udOzEfn/2S4dIL.', '["ROLE_ADMIN"]', '2017-09-20 17:16:40', '2017-09-20 17:16:40', true);
INSERT INTO admin_user (id, username, email, password, roles, created, updated, is_active) VALUES (71, 'admin', 'admin124@admin.com', '$2y$12$A8tO26d0rekZFPr94Hrj1uYYF9sQr.auuAFlX/udOzEfn/2S4dIL.', '["ROLE_SUPPORT"]', '2017-09-14 12:53:41', '2017-09-14 12:53:41', true);
INSERT INTO admin_user (id, username, email, password, roles, created, updated, is_active) VALUES (69, 'admin', 'admin123@admin.com', '$2y$12$A8tO26d0rekZFPr94Hrj1uYYF9sQr.auuAFlX/udOzEfn/2S4dIL.', '["ROLE_MARKETING"]', '2017-09-14 12:39:21', '2017-09-14 12:39:21', true);
INSERT INTO admin_user (id, username, email, password, roles, created, updated, is_active) VALUES (67, 'Lena', 'admin@admin.com', '$2y$12$A8tO26d0rekZFPr94Hrj1uYYF9sQr.auuAFlX/udOzEfn/2S4dIL.', '["ROLE_ADMIN"]', '2017-09-14 11:25:27', '2017-09-14 11:25:27', true);


--
-- Name: admin_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: psqlsymfony
--

SELECT pg_catalog.setval('admin_user_id_seq', 73, true);


--
-- Data for Name: migration_versions; Type: TABLE DATA; Schema: public; Owner: psqlsymfony
--

INSERT INTO migration_versions (version) VALUES ('20170821140054');
INSERT INTO migration_versions (version) VALUES ('20170821142040');
INSERT INTO migration_versions (version) VALUES ('20170821142211');
INSERT INTO migration_versions (version) VALUES ('20170821150235');
INSERT INTO migration_versions (version) VALUES ('20170905115801');
INSERT INTO migration_versions (version) VALUES ('20170905121854');
INSERT INTO migration_versions (version) VALUES ('20170905152716');
INSERT INTO migration_versions (version) VALUES ('20170905155759');
INSERT INTO migration_versions (version) VALUES ('20170907121343');
INSERT INTO migration_versions (version) VALUES ('20170919062124');


--
-- Data for Name: permissions; Type: TABLE DATA; Schema: public; Owner: psqlsymfony
--

INSERT INTO permissions (perm_id, perm_desc) VALUES (1, 'create');
INSERT INTO permissions (perm_id, perm_desc) VALUES (2, 'view');
INSERT INTO permissions (perm_id, perm_desc) VALUES (3, 'delete');
INSERT INTO permissions (perm_id, perm_desc) VALUES (4, 'edit');


--
-- Name: permissions_perm_id_seq; Type: SEQUENCE SET; Schema: public; Owner: psqlsymfony
--

SELECT pg_catalog.setval('permissions_perm_id_seq', 4, true);


--
-- Data for Name: role_permissions; Type: TABLE DATA; Schema: public; Owner: psqlsymfony
--

INSERT INTO role_permissions (perm_id, role_id, role_perm_id) VALUES (1, 3, 1);
INSERT INTO role_permissions (perm_id, role_id, role_perm_id) VALUES (2, 3, 2);
INSERT INTO role_permissions (perm_id, role_id, role_perm_id) VALUES (3, 3, 3);
INSERT INTO role_permissions (perm_id, role_id, role_perm_id) VALUES (4, 3, 4);
INSERT INTO role_permissions (perm_id, role_id, role_perm_id) VALUES (2, 4, 5);
INSERT INTO role_permissions (perm_id, role_id, role_perm_id) VALUES (3, 4, 6);
INSERT INTO role_permissions (perm_id, role_id, role_perm_id) VALUES (4, 4, 7);
INSERT INTO role_permissions (perm_id, role_id, role_perm_id) VALUES (2, 5, 8);
INSERT INTO role_permissions (perm_id, role_id, role_perm_id) VALUES (4, 5, 9);


--
-- Name: role_permissions_role_perm_id_seq; Type: SEQUENCE SET; Schema: public; Owner: psqlsymfony
--

SELECT pg_catalog.setval('role_permissions_role_perm_id_seq', 1, false);


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: psqlsymfony
--

INSERT INTO roles (role_id, role_name) VALUES (3, 'ROLE_ADMIN');
INSERT INTO roles (role_id, role_name) VALUES (4, 'ROLE_MARKETING');
INSERT INTO roles (role_id, role_name) VALUES (5, 'ROLE_SUPPORT');


--
-- Name: roles_role_id_seq; Type: SEQUENCE SET; Schema: public; Owner: psqlsymfony
--

SELECT pg_catalog.setval('roles_role_id_seq', 5, true);


--
-- Name: admin_user admin_user_pkey; Type: CONSTRAINT; Schema: public; Owner: psqlsymfony
--

ALTER TABLE ONLY admin_user
    ADD CONSTRAINT admin_user_pkey PRIMARY KEY (id);


--
-- Name: migration_versions migration_versions_pkey; Type: CONSTRAINT; Schema: public; Owner: psqlsymfony
--

ALTER TABLE ONLY migration_versions
    ADD CONSTRAINT migration_versions_pkey PRIMARY KEY (version);


--
-- Name: permissions permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: psqlsymfony
--

ALTER TABLE ONLY permissions
    ADD CONSTRAINT permissions_pkey PRIMARY KEY (perm_id);


--
-- Name: role_permissions role_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: psqlsymfony
--

ALTER TABLE ONLY role_permissions
    ADD CONSTRAINT role_permissions_pkey PRIMARY KEY (role_perm_id);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: psqlsymfony
--

ALTER TABLE ONLY roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (role_id);


--
-- Name: idx_1fba94e6d60322ac; Type: INDEX; Schema: public; Owner: psqlsymfony
--

CREATE INDEX idx_1fba94e6d60322ac ON role_permissions USING btree (role_id);


--
-- Name: idx_1fba94e6fa6311ef; Type: INDEX; Schema: public; Owner: psqlsymfony
--

CREATE INDEX idx_1fba94e6fa6311ef ON role_permissions USING btree (perm_id);


--
-- Name: uniq_ad8a54a9e7927c74; Type: INDEX; Schema: public; Owner: psqlsymfony
--

CREATE UNIQUE INDEX uniq_ad8a54a9e7927c74 ON admin_user USING btree (email);


--
-- Name: role_permissions fk_1fba94e6d60322ac; Type: FK CONSTRAINT; Schema: public; Owner: psqlsymfony
--

ALTER TABLE ONLY role_permissions
    ADD CONSTRAINT fk_1fba94e6d60322ac FOREIGN KEY (role_id) REFERENCES roles(role_id);


--
-- Name: role_permissions fk_1fba94e6fa6311ef; Type: FK CONSTRAINT; Schema: public; Owner: psqlsymfony
--

ALTER TABLE ONLY role_permissions
    ADD CONSTRAINT fk_1fba94e6fa6311ef FOREIGN KEY (perm_id) REFERENCES permissions(perm_id);


--
-- PostgreSQL database dump complete
--

