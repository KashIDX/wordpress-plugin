import React, { useState, useEffect } from 'react'
import PostCell from './PostCell.js'
import LoadingSpinner from './LoadingSpinner.js'
import axios from 'axios'
import styled from 'styled-components'

/* global impressGmbAdmin, ajaxurl, FormData */
/* eslint no-undef: "error" */

const HeaderContainer = styled.div`
  display: flex;
`
const Header = styled.div`
  align-items: center;
  color: #008abe;
  display: flex;
  font-size: 24px;
  font-weight: 500;
  height: 42px;
  width: 100%;
  margin-bottom: 37px;
`
const ListingPostsContainer = styled.div`
  display: flex;
  flex-direction: column;
  margin: auto;
  width: 100%;
`
const PostsGrid = styled.div`
  margin: 0px 28px;
  padding: 0 4px;
  display: grid;
  grid-template-columns: repeat(6, 200px);
  justify-content: space-between;
  @media (max-width: 1760px) {
    grid-template-columns: repeat(5, 200px);
  }
  @media (max-width: 1500px) {
    grid-template-columns: repeat(4, 200px);
  }
  @media (max-width: 1240px) {
    grid-template-columns: repeat(3, 200px);
  }
  @media (max-width: 880px) {
    grid-template-columns: repeat(2, 200px);
    margin: auto;
  }
  @media (max-width: 650px) {
    grid-template-columns: repeat(1, 200px);
    margin: auto;
  }
  // Hide button container for listing cells.
  & *:hover > .button-container {
    display: none;
  }
`

function ListingPostsPane (props) {
  const [isLoaded, setIsLoaded] = useState(false)
  const [listings, setListings] = useState([])

  useEffect(() => {
    const formData = new FormData()
    formData.append('action', 'impress_gmb_get_listing_posts')
    formData.append('nonce', impressGmbAdmin['nonce-gmb-get-listing-posts'])
    axios.post(ajaxurl, formData)
      .then((response) => {
        setIsLoaded(true)
        setListings(response.data)
      }, (error) => {
        console.log(error)
      })
  }, [])

  return (
    <ListingPostsContainer>
      <HeaderContainer>
        <Header>Listings</Header>
      </HeaderContainer>
      {(!isLoaded) ? <LoadingSpinner /> : ''}
      <PostsGrid>
        {listings.map(listing => (
          <PostCell
            key={listing.id}
            id={listing.id}
            title={listing.title}
            postUrl={listing.postUrl}
            imageUrl={listing.imageUrl}
            summary={listing.summary}
            updatePostEditor={props.updatePostEditor}
            dragOperationType='createFromListing'
            cellDrag={props.cellDrag}
          />
        ))}
      </PostsGrid>
    </ListingPostsContainer>
  )
}

export default ListingPostsPane
